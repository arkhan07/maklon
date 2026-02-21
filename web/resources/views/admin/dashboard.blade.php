@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('breadcrumb')<span class="text-primary font-semibold text-sm">Dashboard</span>@endsection

@section('content')
<div class="p-6 space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Dashboard Admin</h2>
            <p class="text-slate-400 text-sm mt-0.5">Ringkasan aktivitas platform Maklon.id · {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px]">package_2</span>
            Kelola Order
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Users -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl bg-blue-50">
                    <span class="material-symbols-outlined text-[22px] text-blue-600 ms-filled">group</span>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_users']) }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Total Pengguna</p>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl" style="background:rgba(0,31,61,.06);">
                    <span class="material-symbols-outlined text-[22px] ms-filled" style="color:#001f3d;">package_2</span>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Total</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['total_orders']) }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Total Order</p>
        </div>

        <!-- Active Orders -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl bg-amber-50">
                    <span class="material-symbols-outlined text-[22px] text-amber-600 ms-filled">sync</span>
                </div>
                @if($stats['active_orders'] > 0)
                <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Aktif</span>
                @endif
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['active_orders']) }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Order Aktif</p>
        </div>

        <!-- Revenue This Month -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card hover:shadow-card-hover transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="p-2.5 rounded-xl bg-emerald-50">
                    <span class="material-symbols-outlined text-[22px] text-emerald-600 ms-filled">account_balance_wallet</span>
                </div>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Bulan ini</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Revenue Bulan Ini</p>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-card flex items-center gap-4">
            <div class="p-2.5 rounded-xl bg-red-50 flex-shrink-0">
                <span class="material-symbols-outlined text-[20px] text-red-500">pending_actions</span>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-900">{{ $stats['pending_payments'] }}</p>
                <p class="text-xs text-slate-400 font-medium">Pembayaran Pending</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-card flex items-center gap-4">
            <div class="p-2.5 rounded-xl bg-violet-50 flex-shrink-0">
                <span class="material-symbols-outlined text-[20px] text-violet-600">verified_user</span>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-900">{{ $stats['mou_pending'] }}</p>
                <p class="text-xs text-slate-400 font-medium">MOU Menunggu Review</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-card flex items-center gap-4">
            <div class="p-2.5 rounded-xl bg-teal-50 flex-shrink-0">
                <span class="material-symbols-outlined text-[20px] text-teal-600">check_circle</span>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-900">{{ $stats['orders_completed'] }}</p>
                <p class="text-xs text-slate-400 font-medium">Order Selesai</p>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-card overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-slate-400">package_2</span>
                    <h3 class="font-semibold text-slate-800 text-sm">Order Terbaru</h3>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                    Lihat Semua
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recentOrders as $order)
                <div class="px-5 py-3.5 flex items-center justify-between hover:bg-slate-50/60 transition-colors">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-sm font-semibold text-primary hover:underline">
                                #{{ $order->order_number }}
                            </a>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5 truncate">
                            {{ $order->user?->name }} &middot; {{ $order->product?->name ?? $order->product_name ?? 'Produk tidak ditemukan' }}
                        </p>
                    </div>
                    <span class="ml-3 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->statusColor() }} flex-shrink-0">
                        {{ $order->statusLabel() }}
                    </span>
                </div>
                @empty
                <div class="px-5 py-12 text-center">
                    <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">package_2</span>
                    <p class="text-sm text-slate-400">Belum ada order</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-card overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-slate-400">payments</span>
                    <h3 class="font-semibold text-slate-800 text-sm">Pembayaran Pending</h3>
                    @if($stats['pending_payments'] > 0)
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-red-500 text-white">
                        {{ $stats['pending_payments'] }}
                    </span>
                    @endif
                </div>
                <a href="{{ route('admin.payments.index') }}"
                   class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                    Verifikasi
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($pendingPayments as $payment)
                <div class="px-5 py-3.5 flex items-center justify-between hover:bg-slate-50/60 transition-colors">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $payment->user?->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ method_exists($payment, 'methodLabel') ? $payment->methodLabel() : $payment->method }}
                            &middot;
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.payments.index') }}"
                       class="ml-3 flex-shrink-0 text-amber-700 text-xs font-bold bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg transition-colors">
                        Verifikasi
                    </a>
                </div>
                @empty
                <div class="px-5 py-12 text-center">
                    <span class="material-symbols-outlined text-3xl text-slate-200 block mb-2">check_circle</span>
                    <p class="text-sm text-slate-400">Tidak ada pembayaran pending</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pending Users -->
    @if($pendingUsers->count() > 0)
    <div class="bg-white rounded-xl border border-amber-200 shadow-card overflow-hidden">
        <div class="px-5 py-4 border-b border-amber-100 flex items-center justify-between bg-amber-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-amber-500">pending_actions</span>
                <h3 class="font-semibold text-slate-800 text-sm">User Menunggu Verifikasi</h3>
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-amber-500 text-white">{{ $pendingUsers->count() }}</span>
            </div>
            <a href="{{ route('admin.verifikasi.index') }}"
               class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                Proses Semua
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($pendingUsers as $u)
            <div class="px-5 py-3.5 flex items-center justify-between hover:bg-slate-50/60 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="size-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $u->name }}</p>
                        <p class="text-xs text-slate-400">{{ $u->email }} &middot; {{ $u->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.verifikasi.show', $u) }}"
                   class="text-xs font-semibold text-primary border border-primary/20 px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition-colors">
                    Review
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
