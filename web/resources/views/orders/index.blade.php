@extends('layouts.sidebar')
@section('title', 'Order Saya')
@section('breadcrumb')<span class="text-primary font-medium">Order Saya</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Order Saya</h2>
            <p class="text-slate-500 text-sm">Daftar semua order manufaktur Anda</p>
        </div>
        <a href="{{ route('orders.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-semibold hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-base">add</span> Buat Order Baru
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        @if($orders->isEmpty())
        <div class="p-16 text-center">
            <div class="inline-flex size-16 bg-slate-100 rounded-full items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-400">package_2</span>
            </div>
            <p class="font-medium text-slate-700">Belum ada order</p>
            <p class="text-slate-400 text-sm mt-1">Buat order pertama Anda sekarang</p>
            <a href="{{ route('orders.create') }}" class="inline-flex items-center gap-2 mt-4 bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-base">add</span> Buat Order
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-primary">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ $order->product_name }}</p>
                            @if($order->product_type)<p class="text-xs text-slate-400">{{ $order->product_type }}</p>@endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ number_format($order->quantity) }} Pcs</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->statusColor() }}">
                                {{ $order->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('orders.show', $order) }}" class="text-primary text-sm font-semibold hover:underline">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $orders->links() }}</div>
        @endif
        @endif
    </div>
</div>
@endsection
