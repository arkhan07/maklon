<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\PackagingType;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = ProductCategory::with('children.children.children')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json(['categories' => $categories]);
    }

    public function products(Request $request): JsonResponse
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->orderBy('sort_order')
            ->paginate(30);

        return response()->json($products);
    }

    public function product(Product $product): JsonResponse
    {
        if (!$product->is_active) {
            return response()->json(['message' => 'Produk tidak tersedia'], 404);
        }

        return response()->json(['product' => $product->load('category')]);
    }

    public function materials(Request $request): JsonResponse
    {
        $materials = Material::where('is_available', true)
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $categories = Material::where('is_available', true)->distinct()->pluck('category')->sort()->values();

        return response()->json(['materials' => $materials, 'categories' => $categories]);
    }

    public function packaging(): JsonResponse
    {
        $types = PackagingType::with(['options' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json(['packaging_types' => $types]);
    }

    public function calculatePrice(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'volume_ml' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:100',
            'materials' => 'array',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.dose_ml' => 'required|numeric|min:0.001',
            'packaging_option_id' => 'nullable|exists:packaging_options,id',
            'design_type' => 'nullable|in:jasa_design,own_design,none',
            'sample_requested' => 'boolean',
            'include_bpom' => 'boolean',
            'include_halal' => 'boolean',
            'include_haki_logo' => 'boolean',
            'include_haki_djki' => 'boolean',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->quantity;

        // Base cost
        $baseCost = $product->base_price_per_100ml * ($request->volume_ml / 100) * $qty;

        // Material cost
        $materialCost = 0;
        if ($request->materials) {
            foreach ($request->materials as $item) {
                $material = Material::findOrFail($item['material_id']);
                $materialCost += $material->price_per_ml * $item['dose_ml'] * $qty;
            }
        }

        // Packaging cost
        $packagingCost = 0;
        if ($request->packaging_option_id) {
            $packaging = \App\Models\PackagingOption::find($request->packaging_option_id);
            $packagingCost = $packaging ? $packaging->price * $qty : 0;
        }

        // Design cost
        $designCost = ($request->design_type === 'jasa_design') ? 750000 : 0;

        // Sample cost
        $sampleCost = $request->boolean('sample_requested') ? 500000 : 0;

        // Legal cost
        $legalCost = 0;
        if ($request->boolean('include_bpom', true)) $legalCost += 1250000;
        if ($request->boolean('include_halal')) $legalCost += 2500000;
        if ($request->boolean('include_haki_logo')) $legalCost += 1500000;
        if ($request->boolean('include_haki_djki')) $legalCost += 2750000;

        $subtotalProduct = $baseCost + $materialCost + $packagingCost + $designCost;
        $ppnRate = 11;
        $ppnAmount = ($subtotalProduct + $legalCost + $sampleCost) * ($ppnRate / 100);
        $grandTotal = $subtotalProduct + $legalCost + $sampleCost + $ppnAmount;
        $dpAmount = $legalCost + $sampleCost + ($subtotalProduct * 0.5) + $ppnAmount;
        $remainingAmount = $subtotalProduct * 0.5;

        return response()->json([
            'breakdown' => [
                'base_cost' => round($baseCost),
                'material_cost' => round($materialCost),
                'packaging_cost' => round($packagingCost),
                'design_cost' => round($designCost),
                'sample_cost' => round($sampleCost),
                'subtotal_product' => round($subtotalProduct),
                'legal_cost' => round($legalCost),
                'ppn_rate' => $ppnRate,
                'ppn_amount' => round($ppnAmount),
                'grand_total' => round($grandTotal),
            ],
            'payment_schedule' => [
                'dp_amount' => round($dpAmount),
                'remaining_amount' => round($remainingAmount),
                'dp_label' => 'DP 50% Produk + Legalitas 100% + Sample 100% + PPN',
                'remaining_label' => 'Pelunasan 50% Produk (setelah produk jadi)',
            ],
        ]);
    }
}
