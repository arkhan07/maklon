@extends('layouts.sidebar')
@section('title', 'Settings')
@section('breadcrumb')<span class="text-primary font-medium">Settings</span>@endsection

@section('content')
<div class="p-8 max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Pengaturan</h2>
        <p class="text-slate-500 text-sm">Kelola preferensi akun Anda</p>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <form method="POST" action="{{ route('settings.update') }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        @csrf @method('PUT')
        <h3 class="font-bold text-slate-800 pb-4 border-b border-slate-100">Notifikasi</h3>

        @foreach([
            ['key' => 'notif_order', 'label' => 'Update Status Order', 'desc' => 'Beritahu saya ketika status order berubah'],
            ['key' => 'notif_invoice', 'label' => 'Invoice Baru', 'desc' => 'Beritahu saya ketika ada invoice baru'],
            ['key' => 'notif_payment', 'label' => 'Konfirmasi Pembayaran', 'desc' => 'Beritahu saya ketika pembayaran diverifikasi'],
        ] as $notif)
        <div class="flex items-center justify-between py-3 border-b border-slate-50">
            <div>
                <p class="text-sm font-semibold text-slate-800">{{ $notif['label'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $notif['desc'] }}</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="{{ $notif['key'] }}" value="1" checked class="sr-only peer"/>
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
            </label>
        </div>
        @endforeach

        <div class="pt-2">
            <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-lg font-bold hover:bg-primary/90 transition-all">Simpan Pengaturan</button>
        </div>
    </form>

    <!-- Danger Zone -->
    <div class="bg-white rounded-xl border border-red-100 shadow-sm p-6">
        <h3 class="font-bold text-red-600 pb-4 border-b border-red-50">Zona Berbahaya</h3>
        <div class="flex items-center justify-between mt-4">
            <div>
                <p class="text-sm font-semibold text-slate-800">Hapus Akun</p>
                <p class="text-xs text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
            </div>
            <button type="button" class="border border-red-300 text-red-600 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-red-50 transition-all" onclick="confirm('Yakin ingin menghapus akun? Ini tidak bisa dibatalkan.') && alert('Fitur belum tersedia.')">
                Hapus Akun
            </button>
        </div>
    </div>
</div>
@endsection
