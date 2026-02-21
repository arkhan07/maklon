@extends('layouts.sidebar')
@section('title', 'Dashboard')
@section('breadcrumb')<span class="text-primary font-semibold text-sm">Overview</span>@endsection

@section('content')
<div class="p-6 space-y-6">

    <!-- Welcome Header -->
    <div class="rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 overflow-hidden relative"
         style="background: linear-gradient(135deg, #001f3d 0%, #003366 60%, #004080 100%);">
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-1">
                <span class="material-symbols-outlined text-amber-400 ms-filled text-[20px]">waving_hand</span>
                <span class="text-white/60 text-sm font-medium">Selamat datang kembali,</span>
            </div>
            <h2 class="text-2xl font-bold text-white tracking-tight">{{ auth()->user()->company_name ?: auth()->user()->name }}</h2>
            <p class="text-white/50 text-sm mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <a href="{{ route('orders.create') }}"
           class="relative z-10 inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary rounded-xl text-sm font-bold hover:bg-slate-50 transition-all shadow-lg flex-shrink-0">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Buat Order Baru
        </a>
        <!-- Background decoration -->
        <div class="absolute right-0 top-0 size-48 rounded-full opacity-10"
             style="background: radial-gradient(circle, #ffffff 0%, transparent 70%); transform: translate(30%, -30%);"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl" style="background: rgba(0,31,61,.06);">
                    <span class="material-symbols-outlined text-[20px] ms-filled" style="color:#001f3d;">list_alt</span>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['total_orders'] }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Total Order</p>
        </div>

        <!-- Active Orders -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl bg-amber-50">
                    <span class="material-symbols-outlined text-[20px] text-amber-600 ms-filled">sync</span>
                </div>
                @if($stats['active_orders'] > 0)
                <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Aktif</span>
                @endif
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['active_orders'] }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Dalam Proses</p>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl bg-emerald-50">
                    <span class="material-symbols-outlined text-[20px] text-emerald-600 ms-filled">check_circle</span>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['completed_orders'] }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Order Selesai</p>
        </div>

        <!-- Pending Invoices -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl bg-blue-50">
                    <span class="material-symbols-outlined text-[20px] text-blue-600 ms-filled">account_balance_wallet</span>
                </div>
                @if($stats['pending_invoices'] > 0)
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Tagihan</span>
                @endif
            </div>
            <p class="text-xl font-bold text-slate-900">Rp {{ number_format($stats['pending_invoices'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Invoice Pending</p>
        </div>
    </div>

    <!-- Content Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-card overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-slate-400">package_2</span>
                    <h3 class="font-semibold text-slate-800 text-sm">Order Terbaru</h3>
                </div>
                <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                    Lihat Semua
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>

            @forelse($recentOrders as $order)
            <div class="px-5 py-3.5 flex items-center justify-between border-b border-slate-50 hover:bg-slate-50/60 transition-colors last:border-b-0">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <div class="size-9 rounded-lg flex items-center justify-center flex-shrink-0"
                         style="background: rgba(0,31,61,.06);">
                        <span class="material-symbols-outlined text-[18px]" style="color:#001f3d;">package_2</span>
                    </div>
                    <div class="min-w-0">
                        <a href="{{ route('orders.show', $order) }}"
                           class="text-sm font-semibold text-slate-800 hover:text-primary transition-colors block truncate">
                            #{{ $order->order_number }}
                        </a>
                        <p class="text-xs text-slate-400 truncate">
                            {{ $order->product?->name ?? $order->product_name ?? 'Produk belum dipilih' }}
                            &middot; {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
                <span class="ml-3 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->statusColor() }} flex-shrink-0">
                    {{ $order->statusLabel() }}
                </span>
            </div>
            @empty
            <div class="px-5 py-14 text-center">
                <div class="size-14 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-3xl text-slate-300">package_2</span>
                </div>
                <p class="text-slate-500 font-semibold text-sm">Belum ada order</p>
                <p class="text-slate-400 text-xs mt-1">Buat order pertama untuk memulai.</p>
                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    Buat Order
                </a>
            </div>
            @endforelse
        </div>

        <!-- Quick Access -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-slate-200 shadow-card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800 text-sm">Akses Cepat</h3>
                </div>
                <div class="p-3 space-y-1.5">
                    <a href="{{ route('orders.create') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-50 transition-colors group">
                        <div class="p-1.5 bg-primary/5 rounded-lg group-hover:bg-primary/10 transition-colors">
                            <span class="material-symbols-outlined text-[18px]" style="color:#001f3d;">add_circle</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Buat Order Baru</p>
                            <p class="text-xs text-slate-400">Mulai proses maklon</p>
                        </div>
                    </a>
                    <a href="{{ route('tracking.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-50 transition-colors group">
                        <div class="p-1.5 bg-amber-50 rounded-lg group-hover:bg-amber-100 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-amber-600">local_shipping</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Tracking Produksi</p>
                            <p class="text-xs text-slate-400">Pantau status produksi</p>
                        </div>
                    </a>
                    <a href="{{ route('invoices.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-50 transition-colors group">
                        <div class="p-1.5 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-blue-600">description</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Invoice</p>
                            <p class="text-xs text-slate-400">Lihat tagihan Anda</p>
                        </div>
                    </a>
                    <a href="{{ route('layanan.legalitas') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-50 transition-colors group">
                        <div class="p-1.5 bg-violet-50 rounded-lg group-hover:bg-violet-100 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-violet-600">gavel</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">PT & Legalitas</p>
                            <p class="text-xs text-slate-400">Urus dokumen legal</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Account Status -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-card p-5">
                <h3 class="font-semibold text-slate-800 text-sm mb-3">Status Akun</h3>
                @php
                    $status = auth()->user()->verification_status ?? 'unverified';
                    $statusMap = [
                        'unverified' => ['bg-slate-100 text-slate-600', 'Belum Verifikasi', 'pending'],
                        'pending'    => ['bg-amber-50 text-amber-700', 'Menunggu Verifikasi', 'schedule'],
                        'verified'   => ['bg-emerald-50 text-emerald-700', 'Terverifikasi', 'verified'],
                        'rejected'   => ['bg-red-50 text-red-600', 'Ditolak', 'cancel'],
                    ];
                    [$badgeClass, $badgeLabel, $badgeIcon] = $statusMap[$status] ?? ['bg-slate-100 text-slate-600', ucfirst($status), 'info'];
                @endphp
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px] ms-filled {{ str_contains($badgeClass, 'emerald') ? 'text-emerald-500' : (str_contains($badgeClass, 'amber') ? 'text-amber-500' : (str_contains($badgeClass, 'red') ? 'text-red-500' : 'text-slate-400')) }}">{{ $badgeIcon }}</span>
                    <div>
                        <p class="text-xs text-slate-500">Verifikasi Akun</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeClass }}">
                            {{ $badgeLabel }}
                        </span>
                    </div>
                </div>
                @if($status === 'unverified' || $status === 'rejected')
                <a href="{{ route('verification.index') }}"
                   class="mt-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-[14px]">upload_file</span>
                    Upload Dokumen
                </a>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
