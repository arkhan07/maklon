@extends('layouts.sidebar')
@section('title', 'Detail Tracking #' . $order->order_number)
@section('breadcrumb')
    <a href="{{ route('tracking.index') }}" class="text-slate-500 hover:text-primary">Tracking Produksi</a>
    <span class="mx-2 text-slate-300">/</span>
    <span class="text-primary font-medium">#{{ $order->order_number }}</span>
@endsection

@section('content')
@php
    $prodSteps = [
        'antri'      => ['label' => 'Antri Produksi',    'icon' => 'pending',          'desc' => 'Order masuk antrian produksi'],
        'mixing'     => ['label' => 'Mixing Formula',    'icon' => 'science',          'desc' => 'Proses mixing bahan baku sedang berlangsung'],
        'qc'         => ['label' => 'Quality Control',   'icon' => 'verified',         'desc' => 'Pemeriksaan kualitas produk'],
        'packing'    => ['label' => 'Packing & Labeling','icon' => 'inventory_2',      'desc' => 'Pengemasan dan pelabelan produk'],
        'siap_kirim' => ['label' => 'Siap Dikirim',      'icon' => 'local_shipping',   'desc' => 'Produk siap dikirimkan'],
        'terkirim'   => ['label' => 'Terkirim',          'icon' => 'done_all',         'desc' => 'Produk telah dikirimkan ke tujuan'],
    ];
    $prodKeys = array_keys($prodSteps);
    $currentIdx = $order->production_status ? (int) array_search($order->production_status, $prodKeys) : -1;
@endphp

<div class="p-8 space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Detail Tracking Order</h2>
            <p class="text-slate-500 text-sm">Pantau status produksi order #{{ $order->order_number }}</p>
        </div>
        <a href="{{ route('orders.show', $order) }}"
           class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-50 transition-all">
            <span class="material-symbols-outlined text-lg">open_in_new</span>
            Lihat Detail Order
        </a>
    </div>

    <!-- Order Summary Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary text-2xl">science</span>
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-lg">#{{ $order->order_number }}</p>
                    <p class="text-slate-600 text-sm">{{ $order->product?->name ?? $order->product_name ?? 'Produk Custom' }}</p>
                    @if($order->brand_name)
                    <p class="text-slate-400 text-xs mt-0.5">Brand: {{ $order->brand_name }}</p>
                    @endif
                </div>
            </div>
            <div class="flex flex-col items-start sm:items-end gap-2">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $order->statusColor() }}">
                    {{ $order->statusLabel() }}
                </span>
                <p class="text-xs text-slate-400">{{ number_format($order->quantity) }} pcs • {{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Production Progress -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-6">Progress Produksi</h3>

        @if($order->production_status)
        <!-- Stepper Desktop -->
        <div class="hidden sm:flex items-center mb-8">
            @foreach($prodSteps as $key => $step)
            @php $i = (int) array_search($key, $prodKeys); @endphp
            <div class="flex flex-col items-center {{ $i < count($prodSteps) - 1 ? 'flex-1' : '' }}">
                <div class="size-10 rounded-full flex items-center justify-center text-sm font-bold transition-all
                    {{ $i < $currentIdx ? 'bg-emerald-500 text-white shadow-md shadow-emerald-200'
                    : ($i == $currentIdx ? 'bg-primary text-white ring-4 ring-primary/20 shadow-md shadow-primary/20'
                    : 'bg-slate-100 text-slate-400') }}">
                    @if($i < $currentIdx)
                        <span class="material-symbols-outlined text-base">check</span>
                    @else
                        <span class="material-symbols-outlined text-base">{{ $step['icon'] }}</span>
                    @endif
                </div>
                <p class="text-[11px] mt-2 font-semibold text-center max-w-[64px]
                    {{ $i == $currentIdx ? 'text-primary' : ($i < $currentIdx ? 'text-emerald-600' : 'text-slate-400') }}">
                    {{ $step['label'] }}
                </p>
            </div>
            @if($i < count($prodSteps) - 1)
            <div class="flex-1 h-0.5 {{ $i < $currentIdx ? 'bg-emerald-400' : 'bg-slate-200' }} mb-5 mx-1"></div>
            @endif
            @endforeach
        </div>

        <!-- Steps List -->
        <div class="space-y-3">
            @foreach($prodSteps as $key => $step)
            @php $i = (int) array_search($key, $prodKeys); @endphp
            <div class="flex items-center gap-4 p-4 rounded-xl border transition-all
                {{ $i == $currentIdx ? 'border-primary/30 bg-primary/5' : ($i < $currentIdx ? 'border-emerald-200 bg-emerald-50/50' : 'border-slate-100 bg-slate-50/50') }}">
                <div class="size-9 rounded-full flex items-center justify-center flex-shrink-0
                    {{ $i < $currentIdx ? 'bg-emerald-500 text-white'
                    : ($i == $currentIdx ? 'bg-primary text-white'
                    : 'bg-slate-200 text-slate-400') }}">
                    @if($i < $currentIdx)
                        <span class="material-symbols-outlined text-sm">check</span>
                    @else
                        <span class="material-symbols-outlined text-sm">{{ $step['icon'] }}</span>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm
                        {{ $i == $currentIdx ? 'text-primary' : ($i < $currentIdx ? 'text-emerald-700' : 'text-slate-500') }}">
                        {{ $step['label'] }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $step['desc'] }}</p>
                </div>
                @if($i == $currentIdx)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary text-white rounded-full text-xs font-semibold">
                    <span class="size-1.5 bg-white rounded-full animate-pulse"></span>
                    Sekarang
                </span>
                @elseif($i < $currentIdx)
                <span class="text-xs text-emerald-600 font-semibold">Selesai</span>
                @endif
            </div>
            @endforeach
        </div>

        @if($order->tracking_number)
        <div class="mt-6 pt-6 border-t border-slate-100">
            <div class="flex items-center gap-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <span class="material-symbols-outlined text-blue-500 text-2xl">local_shipping</span>
                <div>
                    <p class="font-semibold text-blue-800 text-sm">Informasi Pengiriman</p>
                    <p class="text-blue-600 text-sm mt-0.5">
                        Kurir: <strong>{{ $order->courier }}</strong> •
                        No. Resi: <strong>{{ $order->tracking_number }}</strong>
                    </p>
                </div>
            </div>
        </div>
        @endif

        @else
        <div class="flex items-center gap-4 p-5 bg-amber-50 border border-amber-200 rounded-xl">
            <span class="material-symbols-outlined text-amber-500 text-2xl">schedule</span>
            <div>
                <p class="font-semibold text-amber-800">Belum Dijadwalkan</p>
                <p class="text-amber-600 text-sm mt-0.5">Jadwal produksi sedang diproses oleh tim kami. Anda akan mendapat notifikasi segera.</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Invoice & Payment Summary -->
    @if($order->invoices && $order->invoices->isNotEmpty())
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Status Pembayaran</h3>
        <div class="space-y-3">
            @foreach($order->invoices as $invoice)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                <div>
                    <p class="font-semibold text-sm text-slate-800">{{ $invoice->invoice_number }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Jatuh tempo: {{ $invoice->due_date?->format('d M Y') ?? '-' }}
                        @if($invoice->notes) • {{ $invoice->notes }}@endif
                    </p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-slate-900 text-sm">{{ $invoice->formattedAmount() }}</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium mt-1 {{ $invoice->statusColor() }}">
                        {{ $invoice->statusLabel() }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 text-right">
            <a href="{{ route('invoices.index') }}"
               class="text-sm font-semibold text-primary hover:underline inline-flex items-center gap-1">
                Kelola Pembayaran
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Back button -->
    <div>
        <a href="{{ route('tracking.index') }}"
           class="inline-flex items-center gap-2 text-slate-600 hover:text-primary text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Tracking
        </a>
    </div>
</div>
@endsection
