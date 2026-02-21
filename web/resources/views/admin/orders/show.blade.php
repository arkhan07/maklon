@extends('layouts.admin')
@section('title', 'Detail Order')
@section('breadcrumb')
    <a href="{{ route('admin.orders.index') }}" class="hover:text-primary transition-colors">Kelola Order</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">#{{ $order->order_number }}</span>
@endsection

@section('content')
<div class="p-8 max-w-4xl mx-auto space-y-6">
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-red-500">error</span>
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-primary">#{{ $order->order_number }}</h2>
                        <p class="text-slate-500 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $order->statusColor() }}">{{ $order->statusLabel() }}</span>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Produk</p><p class="font-semibold text-slate-800 mt-1">{{ $order->product?->name ?? $order->product_name ?? '-' }}</p>@if($order->brand_name)<p class="text-xs text-slate-400">Brand: {{ $order->brand_name }}</p>@endif</div>
                    <div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Jumlah</p><p class="font-semibold text-slate-800 mt-1">{{ number_format($order->quantity) }} Pcs</p></div>
                    @if($order->total_amount > 0)<div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Estimasi</p><p class="font-semibold text-slate-800 mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p></div>@endif
                    @if($order->dp_amount > 0)<div><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">DP</p><p class="font-semibold text-primary mt-1">Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</p></div>@endif
                    <div class="col-span-2"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Customer</p><p class="font-semibold text-slate-800 mt-1">{{ $order->user->name }}</p><p class="text-sm text-slate-400">{{ $order->user->email }} · {{ $order->user->company_name }}</p></div>
                    @if($order->notes)<div class="col-span-2"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Catatan Customer</p><p class="text-sm text-slate-600 mt-1">{{ $order->notes }}</p></div>@endif
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4">Update Status Order</h3>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Status Baru</label>
                            <select name="status" class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary bg-white">
                                @foreach(['pending' => 'Menunggu Konfirmasi', 'confirmed' => 'Dikonfirmasi', 'in_progress' => 'Dalam Produksi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                                <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Catatan</label>
                            <input type="text" name="notes" value="{{ $order->notes }}" placeholder="Opsional..."
                                class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary"/>
                        </div>
                    </div>
                    <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-primary/90 transition-all">Update Status</button>
                </form>

                {{-- Production Status --}}
                @if(in_array($order->status, ['confirmed','in_progress']))
                <form method="POST" action="{{ route('admin.orders.production', $order) }}" class="space-y-4 pt-4 border-t border-slate-100">
                    @csrf @method('PUT')
                    <h4 class="font-semibold text-slate-700">Update Status Produksi</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Status Produksi</label>
                            <select name="production_status" class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary bg-white">
                                <option value="">-- Belum Mulai --</option>
                                @foreach(['antri'=>'Antri Produksi','mixing'=>'Mixing Formula','qc'=>'Quality Control','packing'=>'Packing & Labeling','siap_kirim'=>'Siap Dikirim','terkirim'=>'Terkirim'] as $v=>$l)
                                <option value="{{ $v }}" {{ $order->production_status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Kurir</label>
                            <input type="text" name="courier" value="{{ $order->courier }}" placeholder="JNE, TIKI, dll..."
                                class="block w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary focus:border-primary"/>
                        </div>
                        <div class="col-span-2 space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Nomor Resi</label>
                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="Nomor tracking pengiriman..."
                                class="block w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary focus:border-primary"/>
                        </div>
                    </div>
                    <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-slate-700 transition-all">Update Produksi</button>
                </form>
                @endif
            </div>

            <!-- Create Invoice -->
            @php $latestInvoice = $order->invoices->first(); @endphp
            @if(!$latestInvoice)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4">Buat Invoice DP</h3>
                @if($order->dp_amount > 0)
                <div class="mb-4 p-3 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-700">
                    Estimasi DP: <strong>Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</strong>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.orders.invoice', $order) }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Total Tagihan (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="amount" required min="1"
                                value="{{ $order->dp_amount > 0 ? (int)$order->dp_amount : '' }}"
                                placeholder="contoh: 5000000"
                                class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Jatuh Tempo <span class="text-red-500">*</span></label>
                            <input type="date" name="due_date" required min="{{ now()->addDay()->format('Y-m-d') }}"
                                value="{{ now()->addDays(7)->format('Y-m-d') }}"
                                class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary"/>
                        </div>
                        <div class="col-span-2 space-y-1.5">
                            <label class="text-sm font-semibold text-slate-700">Catatan Invoice</label>
                            <input type="text" name="notes" placeholder="DP 50% + Biaya Legal..."
                                class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary"/>
                        </div>
                    </div>
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-emerald-700 transition-all">Buat & Kirim Invoice</button>
                </form>
            </div>
            @else
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div><h3 class="font-bold text-slate-800">Invoice</h3><p class="text-sm text-slate-500 mt-1">#{{ $latestInvoice->invoice_number }} — {{ $latestInvoice->formattedAmount() }}</p></div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $latestInvoice->statusColor() }}">{{ $latestInvoice->statusLabel() }}</span>
                        <a href="{{ route('admin.invoices.show', $latestInvoice) }}" class="text-primary text-sm font-semibold hover:underline">Detail</a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Customer Summary -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4">Info Customer</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="size-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">{{ strtoupper(substr($order->user->name,0,1)) }}</div>
                    <div><p class="font-semibold text-sm text-slate-800">{{ $order->user->name }}</p><p class="text-xs text-slate-400">{{ $order->user->email }}</p></div>
                </div>
                @if($order->user->company_name)<div class="text-sm text-slate-600 flex items-center gap-2"><span class="material-symbols-outlined text-slate-400 text-base">corporate_fare</span>{{ $order->user->company_name }}</div>@endif
                @if($order->user->phone)<div class="text-sm text-slate-600 flex items-center gap-2 mt-2"><span class="material-symbols-outlined text-slate-400 text-base">phone</span>{{ $order->user->phone }}</div>@endif
                <a href="{{ route('admin.users.show', $order->user) }}" class="mt-4 text-primary text-xs font-semibold hover:underline block">Lihat Profil Customer →</a>
            </div>
        </div>
    </div>
</div>
@endsection
