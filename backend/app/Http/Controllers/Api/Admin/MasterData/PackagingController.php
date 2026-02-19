<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\PackagingOption;
use App\Models\PackagingType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackagingController extends Controller
{
    public function indexTypes(): JsonResponse
    {
        $types = PackagingType::with('options')->orderBy('sort_order')->get();

        return response()->json(['packaging_types' => $types]);
    }

    public function storeType(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $type = PackagingType::create($request->only(['name', 'description', 'sort_order']));

        return response()->json(['message' => 'Jenis kemasan berhasil dibuat', 'packaging_type' => $type], 201);
    }

    public function updateType(Request $request, PackagingType $packagingType): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $packagingType->update($request->only(['name', 'description', 'is_active', 'sort_order']));

        return response()->json(['message' => 'Jenis kemasan berhasil diperbarui', 'packaging_type' => $packagingType]);
    }

    public function storeOption(Request $request, PackagingType $packagingType): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'volume_ml' => 'nullable|integer',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|string',
        ]);

        $option = $packagingType->options()->create($request->only(['name', 'description', 'volume_ml', 'price', 'image_url']));

        return response()->json(['message' => 'Opsi kemasan berhasil ditambahkan', 'option' => $option], 201);
    }

    public function updateOption(Request $request, PackagingOption $packagingOption): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'image_url' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $packagingOption->update($request->only(['name', 'description', 'volume_ml', 'price', 'image_url', 'is_active']));

        return response()->json(['message' => 'Opsi kemasan berhasil diperbarui', 'option' => $packagingOption]);
    }

    public function destroyOption(PackagingOption $packagingOption): JsonResponse
    {
        if ($packagingOption->orders()->count() > 0) {
            return response()->json(['message' => 'Kemasan tidak dapat dihapus karena sudah ada order'], 422);
        }

        $packagingOption->delete();

        return response()->json(['message' => 'Opsi kemasan berhasil dihapus']);
    }
}
