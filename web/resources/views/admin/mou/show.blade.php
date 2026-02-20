@extends('layouts.admin')
@section('title', 'Detail MOU')
@section('breadcrumb')
    <a href="{{ route('admin.mou.index') }}" class="hover:text-primary transition-colors">Kelola MOU</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">Detail MOU</span>
@endsection

@section('content')
<div class="p-8 space-y-6 max-w-4xl">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Detail MOU</h2>
            <p class="text-slate-500 text-sm">Tinjau informasi MOU sebelum memberikan keputusan</p>
        </div>
        <a href="{{ route('admin.mou.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali
        </a>
    </div>

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
        <!-- MOU Detail Card -->
        <div class="lg:col-span-2 space-y-4">
            <!-- User Info -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">person</span>
                    <h3 class="font-bold text-slate-800">Informasi User</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Nama</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $mou->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Email</p>
                        <p class="text-sm text-slate-700">{{ $mou->user->email }}</p>
                    </div>
                    @if($mou->user->phone)
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Telepon</p>
                        <p class="text-sm text-slate-700">{{ $mou->user->phone }}</p>
                    </div>
                    @endif
                    @if($mou->user->company_name)
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Perusahaan</p>
                        <p class="text-sm text-slate-700">{{ $mou->user->company_name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Info -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">package_2</span>
                    <h3 class="font-bold text-slate-800">Informasi Order</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Nomor Order</p>
                        <p class="text-sm font-mono font-semibold text-slate-800">{{ $mou->order->order_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Status Order</p>
                        <p class="text-sm text-slate-700">{{ ucfirst($mou->order->status ?? '-') }}</p>
                    </div>
                    @if($mou->order->total_price ?? false)
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Total Harga</p>
                        <p class="text-sm font-semibold text-slate-800">Rp {{ number_format($mou->order->total_price, 0, ',', '.') }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Tanggal Order</p>
                        <p class="text-sm text-slate-700">{{ $mou->order->created_at?->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- MOU Info -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">description</span>
                    <h3 class="font-bold text-slate-800">Informasi MOU</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Tanggal Pengajuan</p>
                        <p class="text-sm text-slate-700">{{ $mou->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    @if($mou->updated_at && $mou->updated_at != $mou->created_at)
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Terakhir Diperbarui</p>
                        <p class="text-sm text-slate-700">{{ $mou->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                    @if($mou->notes ?? false)
                    <div class="col-span-2">
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">Catatan</p>
                        <p class="text-sm text-slate-700">{{ $mou->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status & Action Card -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Status MOU</h4>
                @php
                    $statusMap = [
                        'pending'  => ['bg-amber-50 text-amber-700',    'Pending',         'pending_actions'],
                        'approved' => ['bg-emerald-50 text-emerald-700', 'Disetujui',       'verified'],
                        'rejected' => ['bg-red-50 text-red-600',         'Ditolak',         'cancel'],
                        'signed'   => ['bg-blue-50 text-blue-700',       'Ditandatangani',  'draw'],
                    ];
                    [$badgeClass, $badgeLabel, $badgeIcon] = $statusMap[$mou->status] ?? ['bg-slate-100 text-slate-600', ucfirst($mou->status), 'help'];
                @endphp
                <div class="flex items-center gap-3 p-3 {{ $badgeClass }} rounded-lg">
                    <span class="material-symbols-outlined">{{ $badgeIcon }}</span>
                    <span class="font-semibold text-sm">{{ $badgeLabel }}</span>
                </div>
                <p class="text-xs text-slate-400">Diajukan {{ $mou->created_at->format('d M Y') }}</p>
            </div>

            @if($mou->status === 'pending')
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Keputusan</h4>
                <form method="POST" action="{{ route('admin.mou.approve', $mou) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        onclick="return confirm('Setujui MOU ini?')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        Approve MOU
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.mou.reject', $mou) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        onclick="return confirm('Tolak MOU ini?')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-200 hover:border-red-500 rounded-lg text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-base">cancel</span>
                        Tolak MOU
                    </button>
                </form>
            </div>
            @elseif($mou->status === 'approved')
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-500">verified</span>
                <p class="text-sm text-emerald-700 font-medium">MOU ini sudah disetujui</p>
            </div>
            @elseif($mou->status === 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-red-500">cancel</span>
                <p class="text-sm text-red-700 font-medium">MOU ini sudah ditolak</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
