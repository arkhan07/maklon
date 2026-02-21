<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('category')->orderBy('name')->paginate(30);
        $categories = Material::distinct()->pluck('category')->sort()->values();
        return view('admin.material.index', compact('materials', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category'     => ['required', 'string', 'max:100'],
            'price_per_ml' => ['required', 'numeric', 'min:0'],
            'description'  => ['nullable', 'string'],
        ]);
        Material::create($request->only('name', 'category', 'price_per_ml', 'description') + ['is_available' => true]);
        return redirect()->route('admin.material.index')->with('success', 'Material berhasil ditambahkan.');
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category'     => ['required', 'string', 'max:100'],
            'price_per_ml' => ['required', 'numeric', 'min:0'],
            'description'  => ['nullable', 'string'],
            'is_available' => ['nullable', 'boolean'],
        ]);
        $material->update($request->only('name', 'category', 'price_per_ml', 'description') + ['is_available' => $request->boolean('is_available', true)]);
        return redirect()->route('admin.material.index')->with('success', 'Material berhasil diupdate.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.material.index')->with('success', 'Material berhasil dihapus.');
    }

    public function apiList(Request $request)
    {
        $query = Material::where('is_available', true);
        if ($request->category) $query->where('category', $request->category);
        return response()->json($query->orderBy('name')->get());
    }
}
