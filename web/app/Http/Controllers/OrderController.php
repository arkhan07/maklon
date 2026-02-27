<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Material;
use App\Models\PackagingType;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $categories = \App\Models\ProductCategory::whereNull('parent_id')->with('children.children.children')->where('is_active', true)->orderBy('sort_order')->get();
        return view('orders.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'user_id'      => auth()->id(),
            'order_number' => Order::generateOrderNumber(),
            'status'       => 'draft',
            'current_step' => 1,
            'product_name' => '',
            'quantity'     => 0,
        ]);
        return redirect()->route('orders.show', $order)->with('success', 'Order berhasil dibuat. Silakan lengkapi detail order.');
    }

    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['product.category', 'packagingType', 'mouDocument', 'invoices']);
        $materials = Material::where('is_available', true)->orderBy('category')->orderBy('name')->get();
        $packagingTypes = PackagingType::where('is_active', true)->orderBy('sort_order')->get();
        $categories = \App\Models\ProductCategory::whereNull('parent_id')->with('children.children.children.products')->where('is_active', true)->get();

        $currentStep = (int) $request->input('step', $order->current_step ?? 1);
        if ($currentStep > ($order->current_step ?? 1)) $currentStep = $order->current_step ?? 1;
        if ($currentStep < 1) $currentStep = 1;

        return view('orders.show', compact('order', 'materials', 'packagingTypes', 'categories', 'currentStep'));
    }

    public function updateStep(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        $step = (int) $request->input('step', 1);

        $validated = match($step) {
            1 => $request->validate([
                'brand_type'    => ['required', 'in:haki,undername'],
                'brand_name'    => ['required', 'string', 'max:255'],
                'include_bpom'  => ['nullable', 'boolean'],
                'include_halal' => ['nullable', 'boolean'],
                'include_logo'  => ['nullable', 'boolean'],
                'include_haki'  => ['nullable', 'boolean'],
            ]),
            2 => $request->validate([
                'product_id' => ['required', 'exists:products,id'],
                'volume_ml'  => ['required', 'integer', 'min:1'],
            ]),
            3 => $request->validate([
                'selected_materials' => ['nullable', 'array'],
            ]),
            4 => $request->validate([
                'packaging_type_id' => ['required', 'exists:packaging_types,id'],
                'quantity'          => ['required', 'integer', 'min:100'],
            ]),
            5 => $request->validate([
                'design_option'      => ['required', 'in:service,self_upload,none'],
                'design_file_url'    => ['nullable', 'url'],
                'design_description' => ['nullable', 'string'],
                'request_sample'     => ['nullable', 'boolean'],
            ]),
            6 => [],
            default => [],
        };

        $data = array_merge($validated, ['current_step' => min($step + 1, 6)]);
        
        // Booleans
        $data['include_bpom']     = $request->boolean('include_bpom', true);
        $data['include_halal']    = $request->boolean('include_halal');
        $data['include_logo']     = $request->boolean('include_logo');
        $data['include_haki']     = $request->boolean('include_haki');
        $data['request_sample']   = $request->boolean('request_sample');

        if ($step === 6) {
            $order->update(['status' => 'pending']);
            return redirect()->route('orders.show', $order)->with('success', 'Order berhasil disubmit! Tim kami akan menghubungi Anda segera.');
        }

        $order->update($data);
        $this->recalculate($order->fresh());

        return redirect()->route('orders.show', $order)->with('success', 'Langkah ' . $step . ' berhasil disimpan.');
    }

    public function duplicate(Order $order)
    {
        $this->authorize('view', $order);
        $new = $order->replicate(['order_number', 'status', 'current_step', 'mou_status', 'production_status', 'tracking_number']);
        $new->order_number = Order::generateOrderNumber();
        $new->status       = 'draft';
        $new->current_step = 1;
        $new->mou_status   = 'draft';
        $new->save();
        return redirect()->route('orders.show', $new)->with('success', 'Order berhasil diduplikasi.');
    }

    private function recalculate(Order $order): void
    {
        $legalCost = 0;
        if ($order->include_bpom)  $legalCost += 1250000;
        if ($order->include_halal) $legalCost += 2500000;
        if ($order->include_logo)  $legalCost += 1500000;
        if ($order->include_haki)  $legalCost += 2750000;
        if ($order->brand_type === 'haki' && $order->include_logo) $legalCost += 1500000;

        $baseCost     = $order->product ? ($order->product->base_price * ($order->quantity ?? 100) / 100) : 0;
        $materialCost = 0;
        if ($order->selected_materials) {
            foreach ($order->selected_materials as $mat) {
                $material = Material::find($mat['material_id'] ?? 0);
                if ($material) {
                    $materialCost += $material->price_per_ml * ($mat['dose_ml'] ?? 0) * ($order->quantity ?? 100);
                }
            }
        }
        $packagingCost = $order->packagingType ? ($order->packagingType->price * ($order->quantity ?? 100)) : 0;
        $designCost    = $order->design_option === 'service' ? 750000 : 0;
        $sampleCost    = $order->request_sample ? 500000 : 0;

        $subtotal = $baseCost + $materialCost + $packagingCost + $designCost;
        $ppn      = ($subtotal + $legalCost) * 0.11;
        $total    = $subtotal + $legalCost + $ppn + $sampleCost;
        $dp       = $legalCost + $sampleCost + ($subtotal * 0.5);
        $sisa     = $subtotal * 0.5;

        $order->update([
            'legal_cost'      => $legalCost,
            'base_cost'       => $baseCost,
            'material_cost'   => $materialCost,
            'packaging_cost'  => $packagingCost,
            'design_cost'     => $designCost,
            'sample_cost'     => $sampleCost,
            'ppn'             => $ppn,
            'total_amount'    => $total,
            'dp_amount'       => $dp,
            'remaining_amount'=> $sisa,
        ]);
    }

    public function apiProducts(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        return response()->json($query->orderBy('name')->get());
    }

    public function apiProduct(Product $product)
    {
        return response()->json($product->load('category'));
    }

    public function apiMaterials(Request $request)
    {
        $query = Material::where('is_available', true);
        if ($request->category) {
            $query->where('category', $request->category);
        }
        return response()->json($query->orderBy('name')->get());
    }

    public function apiPackaging()
    {
        return response()->json(PackagingType::where('is_active', true)->orderBy('sort_order')->get());
    }
}
