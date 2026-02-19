@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('breadcrumb')
    <span class="text-primary font-medium">Overview</span>
@endsection

@section('content')
<div class="p-8 space-y-8">
    <div class="flex items-end justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Dashboard Overview</h2>
            <p class="text-slate-500 text-sm">Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Berikut ringkasan akun Anda.</p>
        </div>
        <button class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-semibold transition-all shadow-sm">
            <span class="material-symbols-outlined" style="font-size:20px">add</span>
            Buat Order Baru
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Order</p>
                    <h3 class="text-2xl font-bold mt-1">0</h3>
                </div>
                <div class="p-2 bg-primary/5 text-primary rounded-lg">
                    <span class="material-symbols-outlined">list_alt</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-[13px]">
                <span class="text-slate-400">Belum ada order</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Diproses</p>
                    <h3 class="text-2xl font-bold mt-1">0</h3>
                </div>
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                    <span class="material-symbols-outlined">sync</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-[13px]">
                <span class="text-slate-400">Tidak ada produksi aktif</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Selesai</p>
                    <h3 class="text-2xl font-bold mt-1">0</h3>
                </div>
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-[13px]">
                <span class="text-slate-400">Belum ada yang selesai</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Invoice Pending</p>
                    <h3 class="text-2xl font-bold mt-1">Rp 0</h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1 text-[13px]">
                <span class="text-slate-400">Tidak ada tagihan</span>
            </div>
        </div>
    </div>

    <!-- Welcome Banner -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
            <div class="p-3 bg-primary/5 text-primary rounded-xl">
                <span class="material-symbols-outlined text-3xl">waving_hand</span>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-slate-900 text-lg">Selamat datang di Maklon.id!</h4>
                <p class="text-slate-500 text-sm mt-1">Akun Anda sudah aktif. Mulai buat order pertama Anda untuk layanan maklon kosmetik profesional.</p>
            </div>
            <button class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-all">
                Mulai Sekarang
            </button>
        </div>
    </div>

    <!-- Quick Access -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('layanan.legalitas') }}" class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/20 transition-all group cursor-pointer">
            <div class="p-2.5 bg-violet-50 text-violet-600 rounded-lg inline-flex mb-4 group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined">gavel</span>
            </div>
            <h4 class="font-bold text-slate-800 mb-1">Pendirian PT & Legalitas</h4>
            <p class="text-xs text-slate-500">Urus legalitas bisnis maklon Anda dengan mudah</p>
        </a>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/20 transition-all group cursor-pointer">
            <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg inline-flex mb-4 group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined">science</span>
            </div>
            <h4 class="font-bold text-slate-800 mb-1">Formulasi Produk</h4>
            <p class="text-xs text-slate-500">Konsultasi formula kosmetik dengan tim ahli kami</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/20 transition-all group cursor-pointer">
            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg inline-flex mb-4 group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
            <h4 class="font-bold text-slate-800 mb-1">Packaging & Desain</h4>
            <p class="text-xs text-slate-500">Temukan solusi packaging premium untuk produk Anda</p>
        </div>
    </div>

    <!-- Recent Orders (empty state) -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h4 class="font-bold text-slate-900">Order Terbaru</h4>
            <button class="text-primary text-sm font-semibold hover:underline">Lihat Semua</button>
        </div>
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center size-16 bg-slate-100 rounded-full mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-400">package_2</span>
            </div>
            <p class="text-slate-500 font-medium">Belum ada order</p>
            <p class="text-slate-400 text-sm mt-1">Buat order pertama Anda untuk memulai proses maklon.</p>
        </div>
    </div>
</div>
@endsection
