@extends('layouts.admin')
@section('title', 'Kelola Order')
@section('breadcrumb')<span class="text-primary font-medium">Kelola Order</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div class="flex items-center justify-between">
        <div><h2 class="text-2xl font-bold text-slate-900">Kelola Order</h2><p class="text-slate-500 text-sm">Semua order dari customer</p></div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Filters -->
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari order, produk, customer..."
            class="flex-1 px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary"/>
        <select name="status" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:ring-primary focus:border-primary">
            <option value="">Semua Status</option>
            @foreach(['pending' => 'Menunggu', 'processing' => 'Diproses', 'qc' => 'QC', 'shipping' => 'Pengiriman', 'done' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">Filter</button>
        @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all">Reset</a>
        @endif
    </form>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-primary">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $order->user->company_name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $order->product_name }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ number_format($order->quantity) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->statusColor() }}">{{ $order->statusLabel() }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary text-sm font-semibold hover:underline">Kelola</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">Tidak ada order ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
