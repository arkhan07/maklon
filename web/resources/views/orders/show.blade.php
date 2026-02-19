@extends('layouts.sidebar')
@section('title', 'Detail Order')
@section('breadcrumb')
    <a href="{{ route('orders.index') }}" class="hover:text-primary transition-colors">Order Saya</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">#{{ $order->order_number }}</span>
@endsection

@section('content')
<div class="p-8 max-w-3xl mx-auto space-y-6">
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Order Header -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-bold text-primary">#{{ $order->order_number }}</h2>
                <p class="text-slate-500 text-sm mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $order->statusColor() }}">
                {{ $order->statusLabel() }}
            </span>
        </div>

        <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4 pt-6 border-t border-slate-100">
            <div>
                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Produk</p>
                <p class="font-semibold text-slate-800 mt-1">{{ $order->product_name }}</p>
                @if($order->product_type)<p class="text-xs text-slate-400">{{ $order->product_type }}</p>@endif
            </div>
            <div>
                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Jumlah</p>
                <p class="font-semibold text-slate-800 mt-1">{{ number_format($order->quantity) }} Pcs</p>
            </div>
            @if($order->admin_notes)
            <div>
                <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Catatan Admin</p>
                <p class="text-sm text-slate-600 mt-1">{{ $order->admin_notes }}</p>
            </div>
            @endif
        </div>

        @if($order->notes)
        <div class="mt-4 pt-4 border-t border-slate-100">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Keterangan</p>
            <p class="text-sm text-slate-600">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Progress Tracker -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-6">Progress Produksi</h3>
        @php
            $steps = ['pending' => 'Menunggu', 'processing' => 'Produksi', 'qc' => 'QC', 'shipping' => 'Pengiriman', 'done' => 'Selesai'];
            $statusList = array_keys($steps);
            $currentIdx = array_search($order->status, $statusList);
        @endphp
        @if($order->status !== 'cancelled')
        <div class="flex items-center">
            @foreach($steps as $key => $label)
            @php $idx = array_search($key, $statusList); @endphp
            <div class="flex flex-col items-center {{ $idx < count($steps) - 1 ? 'flex-1' : '' }}">
                <div class="size-9 rounded-full flex items-center justify-center text-sm font-bold
                    {{ $idx < $currentIdx ? 'bg-emerald-500 text-white' : ($idx == $currentIdx ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-slate-100 text-slate-400') }}">
                    @if($idx < $currentIdx)
                        <span class="material-symbols-outlined text-base">check</span>
                    @else
                        {{ $idx + 1 }}
                    @endif
                </div>
                <p class="text-[10px] mt-2 font-medium {{ $idx == $currentIdx ? 'text-primary' : 'text-slate-400' }}">{{ $label }}</p>
            </div>
            @if($idx < count($steps) - 1)
            <div class="flex-1 h-0.5 {{ $idx < $currentIdx ? 'bg-emerald-500' : 'bg-slate-200' }} mb-5"></div>
            @endif
            @endforeach
        </div>
        @else
        <div class="flex items-center gap-3 p-4 bg-red-50 rounded-lg">
            <span class="material-symbols-outlined text-red-500">cancel</span>
            <p class="text-sm text-red-600 font-medium">Order ini dibatalkan</p>
        </div>
        @endif
    </div>

    <!-- Invoice Section -->
    @if($order->invoice)
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800">Invoice</h3>
            <a href="{{ route('invoices.show', $order->invoice) }}" class="text-primary text-sm font-semibold hover:underline">Lihat Detail</a>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">#{{ $order->invoice->invoice_number }}</p>
                <p class="text-xl font-bold text-slate-900 mt-1">{{ $order->invoice->formattedAmount() }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Jatuh tempo: {{ $order->invoice->due_date->format('d M Y') }}</p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->invoice->statusColor() }}">
                    {{ $order->invoice->statusLabel() }}
                </span>
                @if($order->invoice->status !== 'paid')
                <a href="{{ route('payments.create', $order->invoice) }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">
                    Bayar Sekarang
                </a>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="bg-slate-50 rounded-xl border border-slate-200 border-dashed p-6 text-center">
        <span class="material-symbols-outlined text-3xl text-slate-300">receipt_long</span>
        <p class="text-slate-500 text-sm mt-2">Invoice belum dibuat oleh admin</p>
    </div>
    @endif
</div>
@endsection
