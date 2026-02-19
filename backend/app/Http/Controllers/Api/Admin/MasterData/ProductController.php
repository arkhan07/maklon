<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('category')
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when(isset($request->is_active), fn($q) => $q->where('is_active', $request->boolean('is_active')))
            ->orderBy('sort_order')
            ->paginate(50);

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'base_price_per_100ml' => 'numeric|min:0',
            'unit' => 'string|max:50',
            'min_qty' => 'integer|min:1',
            'sort_order' => 'integer',
        ]);

        $product = Product::create([
            ...$request->only(['category_id', 'name', 'description', 'base_price', 'base_price_per_100ml', 'unit', 'min_qty', 'sort_order']),
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['message' => 'Produk berhasil dibuat', 'product' => $product->load('category')], 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'category_id' => 'sometimes|exists:product_categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'sometimes|numeric|min:0',
            'base_price_per_100ml' => 'sometimes|numeric|min:0',
            'is_active' => 'boolean',
            'min_qty' => 'integer|min:1',
        ]);

        $data = $request->only(['category_id', 'description', 'base_price', 'base_price_per_100ml', 'is_active', 'min_qty', 'sort_order']);
        if ($request->has('name')) {
            $data['name'] = $request->name;
            $data['slug'] = Str::slug($request->name);
        }

        $product->update($data);

        return response()->json(['message' => 'Produk berhasil diperbarui', 'product' => $product->load('category')]);
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->orders()->count() > 0) {
            return response()->json(['message' => 'Produk tidak dapat dihapus karena sudah ada order'], 422);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
