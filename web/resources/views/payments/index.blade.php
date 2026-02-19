@extends('layouts.sidebar')
@section('title', 'Pembayaran')
@section('breadcrumb')<span class="text-primary font-medium">Pembayaran</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Riwayat Pembayaran</h2>
        <p class="text-slate-500 text-sm">Semua transaksi pembayaran Anda</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        @if($payments->isEmpty())
        <div class="p-16 text-center">
            <div class="inline-flex size-16 bg-slate-100 rounded-full items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-400">account_balance_wallet</span>
            </div>
            <p class="font-medium text-slate-700">Belum ada transaksi</p>
            <p class="text-slate-400 text-sm mt-1">Riwayat pembayaran akan tampil di sini</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-primary">#{{ $payment->invoice->invoice_number }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $payment->invoice->order->product_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $payment->methodLabel() }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $payment->formattedAmount() }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $payment->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->statusColor() }}">
                                {{ $payment->statusLabel() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $payments->links() }}</div>
        @endif
        @endif
    </div>
</div>
@endsection
