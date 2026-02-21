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
        <p class="font-medium text-slate-700">Tidak ada order dalam produksi</p>
        <p class="text-slate-400 text-sm mt-1">Order yang dikonfirmasi dan sedang diproduksi akan muncul di sini</p>
        <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 mt-4 bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">
            Lihat Order Saya
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($orders as $order)
        @php
            $prodSteps = ['antri'=>'Antri','mixing'=>'Mixing','qc'=>'QC','packing'=>'Packing','siap_kirim'=>'Siap Kirim','terkirim'=>'Terkirim'];
            $prodKeys = array_keys($prodSteps);
            $prodIdx = $order->production_status ? (int) array_search($order->production_status, $prodKeys) : 0;
        @endphp
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <a href="{{ route('orders.show', $order) }}" class="text-lg font-bold text-primary hover:underline">#{{ $order->order_number }}</a>
                    <p class="text-slate-600 text-sm mt-0.5">{{ $order->product?->name ?? $order->product_name ?? '-' }}
                        @if($order->brand_name) — {{ $order->brand_name }}@endif</p>
                    <p class="text-slate-400 text-xs mt-0.5">Dibuat {{ $order->created_at->format('d M Y') }} • {{ number_format($order->quantity) }} pcs</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $order->statusColor() }}">
                    {{ $order->statusLabel() }}
                </span>
            </div>

            @if($order->production_status)
            <div class="flex items-center">
                @foreach($prodSteps as $k => $l)
                @php $i = (int) array_search($k, $prodKeys); @endphp
                <div class="flex flex-col items-center {{ $i < count($prodSteps) - 1 ? 'flex-1' : '' }}">
                    <div class="size-8 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $i < $prodIdx ? 'bg-emerald-500 text-white' : ($i == $prodIdx ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-slate-100 text-slate-400') }}">
                        @if($i < $prodIdx)<span class="material-symbols-outlined text-sm">check</span>@else{{ $i + 1 }}@endif
                    </div>
                    <p class="text-[10px] mt-1.5 font-medium {{ $i == $prodIdx ? 'text-primary' : 'text-slate-400' }}">{{ $l }}</p>
                </div>
                @if($i < count($prodSteps) - 1)
                <div class="flex-1 h-0.5 {{ $i < $prodIdx ? 'bg-emerald-400' : 'bg-slate-200' }} mb-5"></div>
                @endif
                @endforeach
            </div>
            @if($order->tracking_number)
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-3">
                <span class="material-symbols-outlined text-slate-400">local_shipping</span>
                <p class="text-sm text-slate-600">Resi: <span class="font-bold text-slate-800">{{ $order->tracking_number }}</span>
                    @if($order->courier) ({{ $order->courier }})@endif</p>
            </div>
            @endif
            @else
            <div class="flex items-center gap-3 p-4 bg-amber-50 border border-amber-100 rounded-lg">
                <span class="material-symbols-outlined text-amber-500">schedule</span>
                <p class="text-sm text-amber-700">Menunggu jadwal produksi dari tim kami</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Semua Order History -->
    @php $doneOrders = $allOrders->whereIn('status', ['completed', 'cancelled']); @endphp
    @if($doneOrders->isNotEmpty())
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100"><h3 class="font-bold text-slate-800">Riwayat Order</h3></div>
        <div class="divide-y divide-slate-100">
            @foreach($doneOrders as $order)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-semibold text-primary hover:underline">#{{ $order->order_number }}</a>
                    <p class="text-xs text-slate-400">{{ $order->product?->name ?? $order->product_name ?? '-' }} — {{ $order->created_at->format('d M Y') }}</p>
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
