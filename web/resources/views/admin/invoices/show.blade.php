@extends('layouts.admin')
@section('title', 'Detail Invoice')
@section('breadcrumb')
    <a href="{{ route('admin.invoices.index') }}" class="hover:text-primary transition-colors">Invoice</a>
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

    <!-- Invoice Summary -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-primary">#{{ $invoice->invoice_number }}</h2>
                <p class="text-slate-500 text-sm">Dibuat {{ $invoice->created_at->format('d M Y') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $invoice->statusColor() }}">{{ $invoice->statusLabel() }}</span>
        </div>
        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
            <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Customer</p><p class="font-semibold text-slate-800 mt-1">{{ $invoice->user->name }}</p><p class="text-sm text-slate-400">{{ $invoice->user->email }}</p></div>
            <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Order</p><p class="font-semibold text-slate-800 mt-1">{{ $invoice->order->product_name }}</p><a href="{{ route('admin.orders.show', $invoice->order) }}" class="text-xs text-primary hover:underline">#{{ $invoice->order->order_number }}</a></div>
            <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total</p><p class="text-2xl font-black text-primary mt-1">{{ $invoice->formattedAmount() }}</p></div>
            <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Jatuh Tempo</p><p class="font-semibold text-slate-800 mt-1">{{ $invoice->due_date->format('d M Y') }}</p></div>
        </div>
    </div>

    <!-- Update Status -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Update Status Invoice</h3>
        <form method="POST" action="{{ route('admin.invoices.status', $invoice) }}" class="flex items-end gap-4">
            @csrf @method('PUT')
            <div class="flex-1 space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">Status</label>
                <select name="status" class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary bg-white">
                    @foreach(['pending' => 'Belum Dibayar', 'paid' => 'Lunas', 'overdue' => 'Jatuh Tempo'] as $val => $label)
                    <option value="{{ $val }}" {{ $invoice->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg text-sm font-bold hover:bg-primary/90 transition-all">Update</button>
        </form>
    </div>

    <!-- Payment History -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100"><h3 class="font-bold text-slate-800">Riwayat Pembayaran</h3></div>
        @if($invoice->payments->isEmpty())
        <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada pembayaran</div>
        @else
        <div class="divide-y divide-slate-100">
            @foreach($invoice->payments as $payment)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $payment->methodLabel() }}</p>
                    <p class="text-xs text-slate-400">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                    @if($payment->proof_file)<a href="{{ asset('storage/'.$payment->proof_file) }}" target="_blank" class="text-xs text-primary hover:underline">Lihat Bukti Transfer</a>@endif
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-slate-900">{{ $payment->formattedAmount() }}</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->statusColor() }}">{{ $payment->statusLabel() }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
