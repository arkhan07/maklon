@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('breadcrumb')
    <a href="{{ route('admin.produk.index') }}" class="hover:text-primary transition-colors">Kelola Produk</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">Edit Produk</span>
@endsection

@section('content')
<div class="p-8 space-y-6 max-w-2xl">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Edit Produk</h2>
            <p class="text-slate-500 text-sm">Perbarui informasi produk</p>
        </div>
        <a href="{{ route('admin.produk.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-red-500 text-base">error</span>
            <p class="text-sm font-semibold text-red-700">Terdapat kesalahan pada form:</p>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li class="text-sm text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Informasi Produk</h3>
            <span class="text-xs text-slate-400 font-mono">ID: {{ $product->id }}</span>
        </div>
        <form method="POST" action="{{ route('admin.produk.update', $product->id) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    placeholder="Contoh: Serum Vitamin C"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('name') border-red-400 @enderror"
                    required
                >
                @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Slug
                </label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="{{ old('slug', $product->slug) }}"
                    placeholder="slug-produk"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors font-mono @error('slug') border-red-400 @enderror"
                >
                <p class="mt-1 text-xs text-slate-400">Kosongkan untuk generate ulang otomatis dari nama produk</p>
                @error('slug')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Deskripsi
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Deskripsi produk..."
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors resize-none @error('description') border-red-400 @enderror"
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select
                    id="category_id"
                    name="category_id"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('category_id') border-red-400 @enderror"
                    required
                >
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Min Qty -->
            <div>
                <label for="min_qty" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Minimum Order (Pcs) <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    id="min_qty"
                    name="min_qty"
                    value="{{ old('min_qty', $product->min_qty) }}"
                    placeholder="100"
                    min="1"
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('min_qty') border-red-400 @enderror"
                    required
                >
                @error('min_qty')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Base Price -->
            <div>
                <label for="base_price" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Harga Dasar (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                    <input
                        type="number"
                        id="base_price"
                        name="base_price"
                        value="{{ old('base_price', $product->base_price) }}"
                        placeholder="0"
                        min="0"
                        step="1000"
                        class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('base_price') border-red-400 @enderror"
                        required
                    >
                </div>
                @error('base_price')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                    class="size-4 rounded border-slate-300 text-primary focus:ring-primary/30"
                >
                <div>
                    <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">Aktifkan Produk</label>
                    <p class="text-xs text-slate-400 mt-0.5">Produk aktif akan ditampilkan kepada pengguna</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-base">save</span>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.produk.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from name if slug is cleared
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('input', () => {
        if (slugInput.value !== '') return;
        slugInput.placeholder = nameInput.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    });
</script>
@endpush
