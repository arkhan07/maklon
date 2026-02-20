<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products   = Product::with('category')->orderBy('category_id')->orderBy('name')->paginate(20);
        $categories = ProductCategory::where('level', 1)->with('children')->orderBy('name')->get();
        return view('admin.produk.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:product_categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price'  => ['required', 'numeric', 'min:0'],
            'min_qty'     => ['required', 'integer', 'min:1'],
            'is_active'   => ['nullable', 'boolean'],
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        Product::create($data);
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.produk.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:product_categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price'  => ['required', 'numeric', 'min:0'],
            'min_qty'     => ['required', 'integer', 'min:1'],
            'is_active'   => ['nullable', 'boolean'],
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        $product->update($data);
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function apiList(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);
        if ($request->category_id) $query->where('category_id', $request->category_id);
        return response()->json($query->orderBy('name')->get());
    }
}
