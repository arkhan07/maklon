@extends('layouts.admin')
@section('title', 'Detail Verifikasi')
@section('breadcrumb')
    <a href="{{ route('admin.verifikasi.index') }}" class="hover:text-primary transition-colors">Verifikasi User</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">{{ $user->name }}</span>
@endsection

@section('content')
<div class="p-8 space-y-6 max-w-4xl">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Detail Verifikasi</h2>
            <p class="text-slate-500 text-sm">Tinjau informasi pengguna sebelum memberikan keputusan</p>
        </div>
        <a href="{{ route('admin.verifikasi.index') }}"
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
        <!-- User Detail Card -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center gap-4">
                <div class="size-14 rounded-full bg-primary flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $user->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
            <div class="p-6 space-y-0 divide-y divide-slate-100">
                @php
                    $fields = [
                        ['label' => 'Nama Lengkap',      'icon' => 'person',       'value' => $user->name],
                        ['label' => 'Email',             'icon' => 'mail',         'value' => $user->email],
                        ['label' => 'Nomor Telepon',     'icon' => 'phone',        'value' => $user->phone ?: '-'],
                        ['label' => 'Nama Perusahaan',   'icon' => 'business',     'value' => $user->company_name ?: '-'],
                        ['label' => 'Jenis Usaha',       'icon' => 'category',     'value' => $user->business_type ?: '-'],
                        ['label' => 'NPWP',              'icon' => 'badge',        'value' => $user->npwp ?: '-'],
                        ['label' => 'Alamat',            'icon' => 'location_on',  'value' => $user->address ?: '-'],
                    ];
                @endphp
                @foreach($fields as $field)
                <div class="flex items-start gap-4 py-4">
                    <div class="w-8 flex-shrink-0 mt-0.5">
                        <span class="material-symbols-outlined text-slate-400 text-xl">{{ $field['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-0.5">{{ $field['label'] }}</p>
                        <p class="text-sm text-slate-800 font-medium">{{ $field['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Status & Action Card -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Status Verifikasi</h4>
                @php
                    $statusMap = [
                        'unverified' => ['bg-slate-100 text-slate-600', 'Belum Verifikasi', 'help'],
                        'pending'    => ['bg-amber-50 text-amber-700',  'Pending',           'pending_actions'],
                        'verified'   => ['bg-emerald-50 text-emerald-700', 'Terverifikasi',  'verified'],
                        'rejected'   => ['bg-red-50 text-red-600',      'Ditolak',           'cancel'],
                    ];
                    [$badgeClass, $badgeLabel, $badgeIcon] = $statusMap[$user->verification_status] ?? ['bg-slate-100 text-slate-600', ucfirst($user->verification_status), 'help'];
                @endphp
                <div class="flex items-center gap-3 p-3 {{ $badgeClass }} rounded-lg">
                    <span class="material-symbols-outlined">{{ $badgeIcon }}</span>
                    <span class="font-semibold text-sm">{{ $badgeLabel }}</span>
                </div>
                <p class="text-xs text-slate-400">Terdaftar sejak {{ $user->created_at->format('d M Y, H:i') }}</p>
            </div>

            @if($user->verification_status !== 'verified')
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Keputusan</h4>
                <form method="POST" action="{{ route('admin.verifikasi.approve', $user) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        onclick="return confirm('Setujui verifikasi user ini?')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        Approve Verifikasi
                    </button>
                </form>
                @if($user->verification_status !== 'rejected')
                <form method="POST" action="{{ route('admin.verifikasi.reject', $user) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        onclick="return confirm('Tolak verifikasi user ini? Tindakan ini akan memberi notifikasi kepada user.')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-200 hover:border-red-500 rounded-lg text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-base">cancel</span>
                        Tolak Verifikasi
                    </button>
                </form>
                @endif
            </div>
            @else
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-500">verified</span>
                <p class="text-sm text-emerald-700 font-medium">User ini sudah terverifikasi</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
