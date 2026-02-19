@extends('layouts.sidebar')
@section('title', 'Buat Order Baru')
@section('breadcrumb')
    <a href="{{ route('orders.index') }}" class="hover:text-primary transition-colors">Order Saya</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">Buat Order Baru</span>
@endsection

@section('content')
<div class="p-8 max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Buat Order Baru</h2>
        <p class="text-slate-500 text-sm">Isi detail produk yang ingin Anda maklon</p>
    </div>

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg space-y-1">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-600 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">error</span>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2 space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="product_name">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" required
                    placeholder="contoh: Serum Vitamin C 30ml"
                    class="block w-full px-4 py-3 border @error('product_name') border-red-400 @else border-slate-200 @enderror rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"/>
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="product_type">Jenis Produk</label>
                <select id="product_type" name="product_type"
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all bg-white">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Serum', 'Moisturizer', 'Toner', 'Sunscreen', 'Cleanser', 'Essence', 'Eye Cream', 'Masker', 'Body Lotion', 'Lainnya'] as $type)
                    <option value="{{ $type }}" {{ old('product_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="quantity">Jumlah (Pcs) <span class="text-red-500">*</span></label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="1"
                    placeholder="contoh: 1000"
                    class="block w-full px-4 py-3 border @error('quantity') border-red-400 @else border-slate-200 @enderror rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"/>
            </div>

            <div class="md:col-span-2 space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="notes">Catatan / Keterangan Tambahan</label>
                <textarea id="notes" name="notes" rows="5"
                    placeholder="Deskripsikan kebutuhan spesifik Anda: formula, kemasan, bahan khusus, dll..."
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400 resize-none">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex gap-3">
            <span class="material-symbols-outlined text-blue-500 flex-shrink-0">info</span>
            <p class="text-sm text-blue-700">Setelah order dibuat, tim kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi dan kalkulasi harga.</p>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-primary/90 transition-all shadow-md">
                Kirim Order
            </button>
            <a href="{{ route('orders.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
