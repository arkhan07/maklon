@extends('layouts.admin')
@section('title', 'Verifikasi User')
@section('breadcrumb')<span class="text-primary font-medium">Verifikasi User</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Verifikasi User</h2>
        <p class="text-slate-500 text-sm">Daftar pengguna yang menunggu verifikasi akun</p>
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
            <h3 class="font-bold text-slate-800">Daftar Pengguna Pending</h3>
            <span class="text-xs text-slate-400 font-medium">{{ $users->total() ?? count($users) }} pengguna</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Perusahaan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <a href="{{ route('admin.verifikasi.show', $user) }}" class="text-sm font-semibold text-slate-800 hover:text-primary transition-colors">
                                    {{ $user->name }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->company_name ?: '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = [
                                    'unverified' => ['bg-slate-100 text-slate-600', 'Belum Verifikasi'],
                                    'pending'    => ['bg-amber-50 text-amber-700', 'Pending'],
                                    'verified'   => ['bg-emerald-50 text-emerald-700', 'Terverifikasi'],
                                    'rejected'   => ['bg-red-50 text-red-600', 'Ditolak'],
                                ];
                                [$badgeClass, $badgeLabel] = $statusMap[$user->verification_status] ?? ['bg-slate-100 text-slate-600', ucfirst($user->verification_status)];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.verifikasi.show', $user) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary border border-primary/30 rounded-lg hover:bg-primary hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    Detail
                                </a>
                                <form method="POST" action="{{ route('admin.verifikasi.approve', $user) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        onclick="return confirm('Setujui verifikasi user ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.verifikasi.reject', $user) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        onclick="return confirm('Tolak verifikasi user ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">verified_user</span>
                            <p class="text-slate-400 text-sm">Tidak ada user yang perlu diverifikasi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
