<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackagingType;
use Illuminate\Http\Request;

class PackagingController extends Controller
{
    public function index()
    {
        $packagings = PackagingType::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.kemasan.index', compact('packagings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'type'        => ['required', 'string', 'max:100'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
        PackagingType::create($request->only('name', 'type', 'price', 'description') + ['is_active' => true]);
        return redirect()->route('admin.kemasan.index')->with('success', 'Kemasan berhasil ditambahkan.');
    }

    public function update(Request $request, PackagingType $kemasan)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'type'        => ['required', 'string', 'max:100'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
        ]);
        $kemasan->update($request->only('name', 'type', 'price', 'description') + ['is_active' => $request->boolean('is_active', true)]);
        return redirect()->route('admin.kemasan.index')->with('success', 'Kemasan berhasil diupdate.');
    }

    public function destroy(PackagingType $kemasan)
    {
        $kemasan->delete();
        return redirect()->route('admin.kemasan.index')->with('success', 'Kemasan berhasil dihapus.');
    }

    public function apiList()
    {
        return response()->json(PackagingType::where('is_active', true)->orderBy('sort_order')->get());
    }
}
