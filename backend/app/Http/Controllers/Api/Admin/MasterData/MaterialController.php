<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $materials = Material::when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when(isset($request->is_available), fn($q) => $q->where('is_available', $request->boolean('is_available')))
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(50);

        $categories = Material::distinct()->pluck('category')->sort()->values();

        return response()->json(['materials' => $materials, 'categories' => $categories]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price_per_ml' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $material = Material::create($request->only(['name', 'category', 'price_per_ml', 'description']));

        return response()->json(['message' => 'Bahan berhasil ditambahkan', 'material' => $material], 201);
    }

    public function update(Request $request, Material $material): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:100',
            'price_per_ml' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $material->update($request->only(['name', 'category', 'price_per_ml', 'description', 'is_available']));

        return response()->json(['message' => 'Bahan berhasil diperbarui', 'material' => $material]);
    }

    public function destroy(Material $material): JsonResponse
    {
        $material->delete();

        return response()->json(['message' => 'Bahan berhasil dihapus']);
    }
}
