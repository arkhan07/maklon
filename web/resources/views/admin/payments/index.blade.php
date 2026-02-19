@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran')
@section('breadcrumb')<span class="text-primary font-medium">Verifikasi Pembayaran</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div><h2 class="text-2xl font-bold text-slate-900">Verifikasi Pembayaran</h2><p class="text-slate-500 text-sm">Verifikasi bukti pembayaran dari customer</p></div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <form method="GET" class="flex gap-3">
        <select name="status" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:ring-primary focus:border-primary">
            <option value="">Semua Status</option>
            @foreach(['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold">Filter</button>
        @if(request('status'))<a href="{{ route('admin.payments.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50">Reset</a>@endif
    </form>

    <div class="space-y-4">
        @forelse($payments as $payment)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <p class="font-bold text-slate-900">{{ $payment->user->name }}</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $payment->statusColor() }}">{{ $payment->statusLabel() }}</span>
                    </div>
                    <p class="text-sm text-slate-500">Invoice #{{ $payment->invoice->invoice_number }} · {{ $payment->invoice->order->product_name ?? '' }}</p>
                    <div class="flex items-center gap-4 mt-2">
                        <span class="text-lg font-black text-primary">{{ $payment->formattedAmount() }}</span>
                        <span class="text-sm text-slate-500">via {{ $payment->methodLabel() }}</span>
                        <span class="text-xs text-slate-400">{{ $payment->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($payment->proof_file)
                    <a href="{{ asset('storage/'.$payment->proof_file) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-primary hover:underline mt-2">
                        <span class="material-symbols-outlined text-base">attach_file</span>
                        Lihat Bukti Transfer
                    </a>
                    @endif
                    @if($payment->notes)<p class="text-sm text-slate-600 mt-1 italic">"{{ $payment->notes }}"</p>@endif
                </div>

                @if($payment->status === 'pending')
                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="flex flex-col gap-3 min-w-[200px]">
                    @csrf @method('PUT')
                    <textarea name="notes" rows="2" placeholder="Catatan (opsional)..."
                        class="px-3 py-2 border border-slate-200 rounded-lg text-sm resize-none focus:ring-primary focus:border-primary"></textarea>
                    <div class="flex gap-2">
                        <button type="submit" name="action" value="verified"
                            class="flex-1 bg-emerald-600 text-white py-2 rounded-lg text-sm font-bold hover:bg-emerald-700 transition-all">
                            ✓ Verifikasi
                        </button>
                        <button type="submit" name="action" value="rejected"
                            class="flex-1 bg-red-50 text-red-600 border border-red-200 py-2 rounded-lg text-sm font-bold hover:bg-red-100 transition-all">
                            ✗ Tolak
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-16 text-center">
            <div class="inline-flex size-16 bg-slate-100 rounded-full items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-400">payments</span>
            </div>
            <p class="font-medium text-slate-700">Tidak ada pembayaran</p>
        </div>
        @endforelse
        @if($payments->hasPages())<div class="mt-4">{{ $payments->links() }}</div>@endif
    </div>
</div>
@endsection
