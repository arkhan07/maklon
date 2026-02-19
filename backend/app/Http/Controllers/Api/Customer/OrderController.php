<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderLegalItem;
use App\Models\OrderMaterial;
use App\Services\InvoiceService;
use App\Services\MouService;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService,
        private MouService $mouService,
        private NotificationService $notificationService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()
            ->orders()
            ->with(['product', 'latestTracking', 'invoices'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return response()->json($orders);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        $order->load([
            'product.category',
            'packagingOption.packagingType',
            'orderMaterials.material',
            'legalItems',
            'invoices',
            'payments',
            'mou',
            'productionTrackings.updatedBy',
            'latestTracking',
        ]);

        return response()->json(['order' => new OrderResource($order)]);
    }

    // Step 1: Start order / set brand & legal
    public function storeStep1(Request $request): JsonResponse
    {
        if (!$request->user()->canOrder()) {
            return response()->json(['message' => 'Akun belum terverifikasi untuk melakukan order'], 403);
        }

        $validated = $request->validate([
            'brand_type' => ['required', Rule::in(['haki', 'undername'])],
            'brand_name' => 'required|string|max:255',
            'brand_logo_url' => 'nullable|string',
            'brand_description' => 'nullable|string',
            'brand_visual_description' => 'nullable|string',
            'brand_name_translation' => 'nullable|string',
            'include_bpom' => 'boolean',
            'include_halal' => 'boolean',
            'include_haki_logo' => 'boolean',
            'include_haki_djki' => 'boolean',
        ]);

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $request->user()->id,
            'status' => 'draft',
            ...$validated,
            'include_bpom' => true, // always mandatory
        ]);

        return response()->json([
            'message' => 'Step 1 berhasil disimpan',
            'order' => new OrderResource($order),
        ], 201);
    }

    // Step 2: Select product
    public function updateStep2(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'volume_ml' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:100',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Step 2 berhasil disimpan',
            'order' => new OrderResource($order->load('product')),
        ]);
    }

    // Step 3: Add-on materials
    public function updateStep3(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'materials' => 'required|array',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.dose_ml' => 'required|numeric|min:0.001',
        ]);

        // Remove old materials
        $order->orderMaterials()->delete();

        // Add new materials
        foreach ($validated['materials'] as $item) {
            $material = \App\Models\Material::findOrFail($item['material_id']);
            $dose = $item['dose_ml'];
            $qty = $order->quantity ?? 1;
            $subtotal = $material->price_per_ml * $dose * $qty;

            OrderMaterial::create([
                'order_id' => $order->id,
                'material_id' => $material->id,
                'dose_ml' => $dose,
                'price_per_ml' => $material->price_per_ml,
                'subtotal' => $subtotal,
            ]);
        }

        return response()->json([
            'message' => 'Step 3 berhasil disimpan',
            'order' => new OrderResource($order->load('orderMaterials.material')),
        ]);
    }

    // Step 4: Packaging
    public function updateStep4(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'packaging_option_id' => 'required|exists:packaging_options,id',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Step 4 berhasil disimpan',
            'order' => new OrderResource($order->load('packagingOption.packagingType')),
        ]);
    }

    // Step 5: Design packaging
    public function updateStep5(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'design_type' => ['required', Rule::in(['jasa_design', 'own_design', 'none'])],
            'design_file_url' => 'nullable|string',
            'design_description' => 'nullable|string',
        ]);

        $design_price = $validated['design_type'] === 'jasa_design' ? 750000 : 0;

        $order->update([...$validated, 'design_price' => $design_price]);

        return response()->json([
            'message' => 'Step 5 berhasil disimpan',
            'order' => new OrderResource($order),
        ]);
    }

    // Step 5.5: Sample request
    public function updateStep5Sample(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'sample_requested' => 'required|boolean',
        ]);

        $sample_price = $validated['sample_requested'] ? 500000 : 0;

        $order->update([
            'sample_requested' => $validated['sample_requested'],
            'sample_price' => $sample_price,
            'sample_status' => $validated['sample_requested'] ? 'pending' : 'none',
        ]);

        return response()->json([
            'message' => 'Pilihan sample berhasil disimpan',
            'order' => new OrderResource($order),
        ]);
    }

    // Step 6: Review and submit order
    public function submit(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        if ($order->status !== 'draft') {
            return response()->json(['message' => 'Order sudah disubmit sebelumnya'], 422);
        }

        DB::transaction(function () use ($order) {
            // Recalculate pricing
            $this->invoiceService->calculateOrderPricing($order);

            // Build legal items
            $order->legalItems()->delete();
            $this->buildLegalItems($order);

            // Update status
            $order->update(['status' => 'submitted']);

            // Create first invoice (DP)
            $this->invoiceService->createDpInvoice($order);

            // Generate MOU
            $this->mouService->generate($order);
        });

        $this->notificationService->send(
            $order->user,
            'Order Berhasil Disubmit',
            "Order #{$order->order_number} telah disubmit. Silakan download dan tanda tangani MOU.",
            'success',
            Order::class,
            $order->id
        );

        return response()->json([
            'message' => 'Order berhasil disubmit',
            'order' => new OrderResource($order->fresh()->load(['legalItems', 'mou', 'invoices'])),
        ]);
    }

    private function buildLegalItems(Order $order): void
    {
        $items = [];

        if ($order->include_bpom) {
            $items[] = ['item_type' => 'bpom', 'label' => 'Izin Edar BPOM', 'amount' => 1250000, 'is_mandatory' => true];
        }
        if ($order->include_halal) {
            $items[] = ['item_type' => 'halal', 'label' => 'Sertifikasi Halal', 'amount' => 2500000, 'is_mandatory' => false];
        }
        if ($order->include_haki_logo) {
            $items[] = ['item_type' => 'haki_logo', 'label' => 'Logo & Pendaftaran Merek', 'amount' => 1500000, 'is_mandatory' => false];
        }
        if ($order->include_haki_djki) {
            $items[] = ['item_type' => 'haki_djki', 'label' => 'Pendaftaran DJKI per Kelas', 'amount' => 2750000, 'is_mandatory' => false];
        }

        foreach ($items as $item) {
            OrderLegalItem::create(array_merge($item, ['order_id' => $order->id]));
        }
    }

    public function duplicate(Request $request, Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        $newOrder = DB::transaction(function () use ($order, $request) {
            $new = $order->replicate(['status', 'order_number', 'shipping_tracking', 'shipping_courier', 'shipped_at', 'completed_at']);
            $new->order_number = Order::generateOrderNumber();
            $new->status = 'draft';
            $new->user_id = $request->user()->id;
            $new->save();

            foreach ($order->orderMaterials as $om) {
                OrderMaterial::create([
                    'order_id' => $new->id,
                    'material_id' => $om->material_id,
                    'dose_ml' => $om->dose_ml,
                    'price_per_ml' => $om->price_per_ml,
                    'subtotal' => $om->subtotal,
                ]);
            }

            return $new;
        });

        return response()->json([
            'message' => 'Order berhasil diduplikasi',
            'order' => new OrderResource($newOrder),
        ], 201);
    }

    public function uploadDesign(Request $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $request->validate([
            'design_file_url' => 'required|string|url',
        ]);

        $order->update(['design_file_url' => $request->design_file_url]);

        return response()->json(['message' => 'File desain berhasil diupload', 'order' => new OrderResource($order)]);
    }
}
