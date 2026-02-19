@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="p-8 space-y-8">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Dashboard Admin</h2>
        <p class="text-slate-500 text-sm">Ringkasan aktivitas platform Maklon.id</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
        @foreach([
            ['label' => 'Total User', 'value' => $stats['total_users'], 'icon' => 'group', 'color' => 'bg-blue-50 text-blue-600'],
            ['label' => 'Total Order', 'value' => $stats['total_orders'], 'icon' => 'package_2', 'color' => 'bg-primary/5 text-primary'],
            ['label' => 'Order Aktif', 'value' => $stats['active_orders'], 'icon' => 'sync', 'color' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Pembayaran Pending', 'value' => $stats['pending_payments'], 'icon' => 'pending_actions', 'color' => 'bg-red-50 text-red-500'],
            ['label' => 'Total Revenue', 'value' => 'Rp '.number_format($stats['revenue'],0,',','.'), 'icon' => 'account_balance_wallet', 'color' => 'bg-emerald-50 text-emerald-600'],
        ] as $stat)
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm col-span-1 {{ $loop->last ? 'lg:col-span-1' : '' }}">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium">{{ $stat['label'] }}</p>
                    <h3 class="text-xl font-bold mt-1 text-slate-900">{{ $stat['value'] }}</h3>
                </div>
                <div class="p-2 {{ $stat['color'] }} rounded-lg">
                    <span class="material-symbols-outlined text-xl">{{ $stat['icon'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Order Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-primary text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentOrders as $order)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-primary hover:underline">#{{ $order->order_number }}</a>
                        <p class="text-xs text-slate-400">{{ $order->user->name }} · {{ $order->product_name }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->statusColor() }}">{{ $order->statusLabel() }}</span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada order</div>
                @endforelse
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Pembayaran Menunggu Verifikasi</h3>
                <a href="{{ route('admin.payments.index') }}" class="text-primary text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($pendingPayments as $payment)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $payment->user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $payment->methodLabel() }} · {{ $payment->formattedAmount() }}</p>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="text-amber-600 text-xs font-bold bg-amber-50 px-3 py-1 rounded-full hover:bg-amber-100 transition-colors">Verifikasi</a>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-sm text-slate-400">Tidak ada pembayaran pending</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
