@extends('layouts.admin')
@section('title', 'Kelola MOU')
@section('breadcrumb')<span class="text-primary font-medium">Kelola MOU</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Kelola MOU</h2>
        <p class="text-slate-500 text-sm">Daftar MOU yang menunggu persetujuan</p>
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

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Daftar MOU</h3>
            <span class="text-xs text-slate-400 font-medium">{{ method_exists($mous, 'total') ? $mous->total() : count($mous) }} MOU</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No. Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status MOU</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mous as $mou)
                    @php
                        $statusMap = [
                            'pending'  => ['bg-amber-50 text-amber-700',    'Pending'],
                            'approved' => ['bg-emerald-50 text-emerald-700', 'Disetujui'],
                            'rejected' => ['bg-red-50 text-red-600',         'Ditolak'],
                            'signed'   => ['bg-blue-50 text-blue-700',       'Ditandatangani'],
                        ];
                        [$badgeClass, $badgeLabel] = $statusMap[$mou->status] ?? ['bg-slate-100 text-slate-600', ucfirst($mou->status)];
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($mou->user->name, 0, 1)) }}
                                </div>
                                <a href="{{ route('admin.mou.show', $mou) }}" class="text-sm font-semibold text-slate-800 hover:text-primary transition-colors">
                                    {{ $mou->user->name }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $mou->user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-mono text-slate-700">{{ $mou->order->order_number ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $mou->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.mou.show', $mou) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary border border-primary/30 rounded-lg hover:bg-primary hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    Detail
                                </a>
                                @if($mou->status === 'pending')
                                <form method="POST" action="{{ route('admin.mou.approve', $mou) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        onclick="return confirm('Setujui MOU ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.mou.reject', $mou) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        onclick="return confirm('Tolak MOU ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                        Reject
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">description</span>
                            <p class="text-slate-400 text-sm">Tidak ada MOU yang perlu ditinjau</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($mous, 'hasPages') && $mous->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $mous->links() }}</div>
        @endif
    </div>
</div>
@endsection
