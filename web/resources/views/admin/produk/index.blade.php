@extends('layouts.admin')
@section('title', 'Kelola Produk')
@section('breadcrumb')<span class="text-primary font-medium">Kelola Produk</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Kelola Produk</h2>
            <p class="text-slate-500 text-sm">Manajemen daftar produk maklon</p>
        </div>
        <a href="{{ route('admin.produk.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
            <span class="material-symbols-outlined text-base">add</span>
            Tambah Produk
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-red-500">error</span>
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Daftar Produk</h3>
            <span class="text-xs text-slate-400 font-medium">{{ method_exists($products, 'total') ? $products->total() : count($products) }} produk</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Dasar</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $product->name }}</p>
                                <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $product->slug }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $product->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-800">
                                Rp {{ number_format($product->base_price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                    <span class="size-1.5 rounded-full bg-slate-400"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.produk.edit', $product) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-amber-700 border border-amber-200 rounded-lg hover:bg-amber-400 hover:text-white hover:border-amber-400 transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.produk.destroy', $product) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Hapus produk \"{{ addslashes($product->name) }}\"? Tindakan ini tidak dapat dibatalkan.')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">inventory_2</span>
                            <p class="text-slate-400 text-sm mb-4">Belum ada produk</p>
                            <a href="{{ route('admin.produk.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold">
                                <span class="material-symbols-outlined text-base">add</span>
                                Tambah Produk Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($products, 'hasPages') && $products->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $products->links() }}</div>
        @endif
    </div>
</div>
@endsection
