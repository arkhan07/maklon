@extends('layouts.sidebar')
@section('title', 'Detail Invoice')
@section('breadcrumb')
    <a href="{{ route('invoices.index') }}" class="hover:text-primary transition-colors">Invoice</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">#{{ $invoice->invoice_number }}</span>
@endsection

@section('content')
<div class="p-8 max-w-3xl mx-auto space-y-6">
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('info'))
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-blue-500">info</span>
        <p class="text-sm text-blue-700">{{ session('info') }}</p>
    </div>
    @endif

    <!-- Invoice Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8">
        <div class="flex items-start justify-between mb-8">
            <div>
                <div class="flex items-center gap-2 text-primary mb-1">
                    <div class="size-8 bg-primary text-white flex items-center justify-center rounded-lg"><span class="material-symbols-outlined text-lg">factory</span></div>
                    <span class="text-xl font-bold">Maklon.id</span>
                </div>
                <p class="text-xs text-slate-400">Manufacturing Solutions Platform</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-black text-primary">#{{ $invoice->invoice_number }}</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $invoice->statusColor() }} mt-2">
                    {{ $invoice->statusLabel() }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8 pb-8 border-b border-slate-100">
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Tagihan Untuk</p>
                <p class="font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                @if(auth()->user()->company_name)<p class="text-sm text-slate-500">{{ auth()->user()->company_name }}</p>@endif
                <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Order</p>
                <p class="font-semibold text-slate-800">{{ $invoice->order->product_name }}</p>
                <p class="text-sm text-slate-500">{{ number_format($invoice->order->quantity) }} Pcs</p>
                <p class="text-xs text-slate-400 mt-2">Jatuh Tempo: {{ $invoice->due_date->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-2">
            <span class="text-slate-600">Subtotal Manufaktur</span>
            <span class="font-semibold text-slate-800">{{ $invoice->formattedAmount() }}</span>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-slate-200 mt-4">
            <span class="text-lg font-bold text-slate-900">Total</span>
            <span class="text-2xl font-black text-primary">{{ $invoice->formattedAmount() }}</span>
        </div>

        @if($invoice->notes)
        <div class="mt-6 p-4 bg-slate-50 rounded-lg">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Catatan</p>
            <p class="text-sm text-slate-600">{{ $invoice->notes }}</p>
        </div>
        @endif

        @if($invoice->status !== 'paid')
        <div class="mt-8 flex justify-end">
            <a href="{{ route('payments.create', $invoice) }}" class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                <span class="material-symbols-outlined text-base">payments</span>
                Bayar Sekarang
            </a>
        </div>
        @else
        <div class="mt-8 p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-500 text-2xl">verified</span>
            <div>
                <p class="font-semibold text-emerald-700">Invoice Sudah Dilunasi</p>
                <p class="text-xs text-emerald-600">{{ $invoice->paid_at ? $invoice->paid_at->format('d M Y, H:i') : '' }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Riwayat Pembayaran -->
    @if($invoice->payments->isNotEmpty())
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100"><h3 class="font-bold text-slate-800">Riwayat Pembayaran</h3></div>
        <div class="divide-y divide-slate-100">
            @foreach($invoice->payments as $payment)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $payment->methodLabel() }}</p>
                    <p class="text-xs text-slate-400">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->statusColor() }}">
                        {{ $payment->statusLabel() }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
