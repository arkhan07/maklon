@extends('layouts.sidebar')
@section('title', 'Invoice')
@section('breadcrumb')<span class="text-primary font-medium">Invoice</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Invoice</h2>
        <p class="text-slate-500 text-sm">Daftar tagihan dari semua order Anda</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        @if($invoices->isEmpty())
        <div class="p-16 text-center">
            <div class="inline-flex size-16 bg-slate-100 rounded-full items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-400">receipt_long</span>
            </div>
            <p class="font-medium text-slate-700">Belum ada invoice</p>
            <p class="text-slate-400 text-sm mt-1">Invoice akan muncul setelah order dikonfirmasi</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($invoices as $invoice)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-primary">#{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $invoice->order->product_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $invoice->formattedAmount() }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $invoice->due_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $invoice->statusColor() }}">
                                {{ $invoice->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <a href="{{ route('invoices.show', $invoice) }}" class="text-primary text-sm font-semibold hover:underline">Detail</a>
                            @if($invoice->status !== 'paid')
                            <a href="{{ route('payments.create', $invoice) }}" class="text-emerald-600 text-sm font-semibold hover:underline">Bayar</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($invoices->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $invoices->links() }}</div>
        @endif
        @endif
    </div>
</div>
@endsection
