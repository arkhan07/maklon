@extends('layouts.sidebar')
@section('title', 'Tracking Produksi')
@section('breadcrumb')<span class="text-primary font-medium">Tracking Produksi</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Tracking Produksi</h2>
        <p class="text-slate-500 text-sm">Pantau progres produksi order Anda secara real-time</p>
    </div>

    @if($orders->isEmpty())
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-16 text-center">
        <div class="inline-flex size-16 bg-slate-100 rounded-full items-center justify-center mb-4">
            <span class="material-symbols-outlined text-3xl text-slate-400">local_shipping</span>
        </div>
        <p class="font-medium text-slate-700">Tidak ada order aktif</p>
        <p class="text-slate-400 text-sm mt-1">Semua order sudah selesai atau belum ada order</p>
        <a href="{{ route('orders.create') }}" class="inline-flex items-center gap-2 mt-4 bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">
            Buat Order Baru
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($orders as $order)
        @php
            $steps = ['pending', 'processing', 'qc', 'shipping', 'done'];
            $labels = ['Menunggu', 'Produksi', 'QC', 'Pengiriman', 'Selesai'];
            $currentIdx = array_search($order->status, $steps);
            if ($currentIdx === false) $currentIdx = 0;
        @endphp
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <a href="{{ route('orders.show', $order) }}" class="text-lg font-bold text-primary hover:underline">#{{ $order->order_number }}</a>
                    <p class="text-slate-600 text-sm mt-0.5">{{ $order->product_name }} — {{ number_format($order->quantity) }} Pcs</p>
                    <p class="text-slate-400 text-xs mt-0.5">Dibuat {{ $order->created_at->format('d M Y') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $order->statusColor() }}">
                    {{ $order->statusLabel() }}
                </span>
            </div>

            <!-- Progress Steps -->
            <div class="flex items-center">
                @foreach($steps as $i => $step)
                <div class="flex flex-col items-center {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                    <div class="size-8 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $i < $currentIdx ? 'bg-emerald-500 text-white' : ($i == $currentIdx ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-slate-100 text-slate-400') }}">
                        @if($i < $currentIdx)
                            <span class="material-symbols-outlined text-sm">check</span>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    <p class="text-[10px] mt-1.5 font-medium {{ $i == $currentIdx ? 'text-primary' : 'text-slate-400' }}">{{ $labels[$i] }}</p>
                </div>
                @if($i < count($steps) - 1)
                <div class="flex-1 h-0.5 {{ $i < $currentIdx ? 'bg-emerald-500' : 'bg-slate-200' }} mb-5"></div>
                @endif
                @endforeach
            </div>

            @if($order->admin_notes)
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-start gap-2">
                <span class="material-symbols-outlined text-primary text-base flex-shrink-0">comment</span>
                <p class="text-sm text-slate-600">{{ $order->admin_notes }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Semua Order History -->
    @if($allOrders->whereIn('status', ['done', 'cancelled'])->isNotEmpty())
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100"><h3 class="font-bold text-slate-800">Riwayat Order Selesai</h3></div>
        <div class="divide-y divide-slate-100">
            @foreach($allOrders->whereIn('status', ['done', 'cancelled']) as $order)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-semibold text-primary hover:underline">#{{ $order->order_number }}</a>
                    <p class="text-xs text-slate-400">{{ $order->product_name }} — {{ $order->created_at->format('d M Y') }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->statusColor() }}">
                    {{ $order->statusLabel() }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endif
</div>
@endsection
