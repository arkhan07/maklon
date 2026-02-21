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
        <p class="text-slate-500 text-sm">Kami akan memandu Anda melalui 6 langkah mudah</p>
    </div>

    {{-- Steps overview --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        @php
            $steps = [
                ['icon' => 'storefront',   'title' => 'Brand & Legalitas',      'desc' => 'Tipe brand, nama brand, BPOM, Halal, HAKI'],
                ['icon' => 'science',      'title' => 'Pilih Produk',            'desc' => 'Kategori dan jenis produk yang ingin dibuat'],
                ['icon' => 'biotech',      'title' => 'Formula / Bahan Aktif',   'desc' => 'Komposisi bahan aktif dalam produk'],
                ['icon' => 'inventory_2',  'title' => 'Kemasan & Kuantitas',     'desc' => 'Jenis kemasan dan jumlah produksi'],
                ['icon' => 'palette',      'title' => 'Desain & Sampel',         'desc' => 'Pilihan desain label dan sampel produk'],
                ['icon' => 'task_alt',     'title' => 'Review & Submit',         'desc' => 'Periksa dan kirimkan order Anda'],
            ];
        @endphp
        @foreach($steps as $i => $s)
        <div class="flex items-start gap-4">
            <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary text-base">{{ $s['icon'] }}</span>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">{{ $i+1 }}. {{ $s['title'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $s['desc'] }}</p>
            </div>
        </div>
        @if($i < count($steps)-1)
        <div class="ml-4 pl-0.5 border-l-2 border-dashed border-slate-200 h-3"></div>
        @endif
        @endforeach
    </div>

    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
        <span class="material-symbols-outlined text-blue-500 flex-shrink-0">info</span>
        <p class="text-sm text-blue-700">Anda dapat menyimpan progress dan melanjutkan kapan saja. Order dalam status <strong>Draft</strong> tidak akan diproses sampai Anda menekan Submit.</p>
    </div>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-primary text-white px-8 py-3.5 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                <span class="material-symbols-outlined text-base">add</span> Mulai Buat Order
            </button>
            <a href="{{ route('orders.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection
