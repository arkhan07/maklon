@extends('layouts.admin')
@section('title', 'Kelola User')
@section('breadcrumb')<span class="text-primary font-medium">Kelola User</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div><h2 class="text-2xl font-bold text-slate-900">Kelola User</h2><p class="text-slate-500 text-sm">Daftar semua pengguna yang terdaftar</p></div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, perusahaan..."
            class="flex-1 px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary"/>
        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold">Cari</button>
        @if(request('search'))<a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50">Reset</a>@endif
    </form>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Perusahaan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                <div><p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p><p class="text-xs text-slate-400">{{ $user->email }}</p></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->company_name ?: '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->phone ?: '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $user->orders_count }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-primary text-sm font-semibold hover:underline">Detail</a>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline">
                                @csrf @method('PUT')
                                <button type="submit" class="text-sm font-semibold {{ $user->is_active ? 'text-red-500 hover:underline' : 'text-emerald-600 hover:underline' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">Tidak ada user ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())<div class="px-6 py-4 border-t border-slate-100">{{ $users->links() }}</div>@endif
    </div>
</div>
@endsection
