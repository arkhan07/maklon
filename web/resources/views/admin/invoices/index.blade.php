@extends('layouts.admin')
@section('title', 'Invoice')
@section('breadcrumb')<span class="text-primary font-medium">Invoice</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div><h2 class="text-2xl font-bold text-slate-900">Kelola Invoice</h2><p class="text-slate-500 text-sm">Semua invoice dan status pembayaran</p></div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <form method="GET" class="flex gap-3">
        <select name="status" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:ring-primary focus:border-primary">
            <option value="">Semua Status</option>
            @foreach(['pending' => 'Belum Dibayar', 'paid' => 'Lunas', 'overdue' => 'Jatuh Tempo'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold">Filter</button>
        @if(request('status'))<a href="{{ route('admin.invoices.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50">Reset</a>@endif
    </form>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-primary">#{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $invoice->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $invoice->order->product_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $invoice->formattedAmount() }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 {{ now()->gt($invoice->due_date) && $invoice->status !== 'paid' ? 'text-red-500 font-medium' : '' }}">{{ $invoice->due_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $invoice->statusColor() }}">{{ $invoice->statusLabel() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-primary text-sm font-semibold hover:underline">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">Tidak ada invoice</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($invoices->hasPages())<div class="px-6 py-4 border-t border-slate-100">{{ $invoices->links() }}</div>@endif
    </div>
</div>
@endsection
