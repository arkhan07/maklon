<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = ProductCategory::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json(['categories' => $categories]);
    }

    public function tree(): JsonResponse
    {
        $categories = ProductCategory::with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json(['tree' => $categories]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
            'icon' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $level = 1;
        if ($request->parent_id) {
            $parent = ProductCategory::findOrFail($request->parent_id);
            $level = $parent->level + 1;
        }

        $category = ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
            'level' => $level,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return response()->json(['message' => 'Kategori berhasil dibuat', 'category' => $category], 201);
    }

    public function update(Request $request, ProductCategory $category): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'icon' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data = $request->only(['icon', 'is_active', 'sort_order']);
        if ($request->has('name')) {
            $data['name'] = $request->name;
            $data['slug'] = Str::slug($request->name);
        }

        $category->update($data);

        return response()->json(['message' => 'Kategori berhasil diperbarui', 'category' => $category]);
    }

    public function destroy(ProductCategory $category): JsonResponse
    {
        if ($category->children()->count() > 0 || $category->products()->count() > 0) {
            return response()->json(['message' => 'Kategori tidak dapat dihapus karena memiliki sub-kategori atau produk'], 422);
        }

        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}
