@extends('layouts.super_admin')
@section('title', 'Audit Log')
@section('breadcrumb', 'Audit Log')

@section('content')
<div class="p-8 space-y-6">

    <!-- Page Heading -->
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Audit Log</h2>
            <p class="text-slate-500 text-sm mt-1">Rekam jejak seluruh aktivitas dan perubahan sistem</p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-100 border border-slate-200 px-3 py-1.5 rounded-full">
            <span class="material-symbols-outlined text-[14px]">schedule</span>
            Segera Hadir
        </span>
    </div>

    <!-- Empty State Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <!-- Decorative Header Strip -->
        <div class="h-1.5 bg-gradient-to-r from-violet-500 via-purple-500 to-indigo-500"></div>

        <!-- Empty State Body -->
        <div class="flex flex-col items-center justify-center py-24 px-8 text-center">

            <!-- Icon -->
            <div class="relative mb-6">
                <div class="size-24 bg-gradient-to-br from-violet-50 to-indigo-50 rounded-3xl flex items-center justify-center border border-violet-100 shadow-sm">
                    <span class="material-symbols-outlined text-5xl text-violet-400">policy</span>
                </div>
                <!-- Decorative dots -->
                <div class="absolute -top-2 -right-2 size-6 bg-violet-100 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[12px] text-violet-500">schedule</span>
                </div>
                <div class="absolute -bottom-1 -left-2 size-4 bg-indigo-200 rounded-full"></div>
            </div>

            <!-- Text -->
            <h3 class="text-xl font-bold text-slate-800">Fitur audit log akan segera hadir</h3>
            <p class="text-slate-500 text-sm mt-2 max-w-sm leading-relaxed">
                Fitur ini sedang dalam tahap pengembangan. Segera, Anda akan dapat memantau seluruh aktivitas
                sistem secara mendetail dari halaman ini.
            </p>

            <!-- Feature Preview List -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-lg w-full">
                <div class="flex flex-col items-center gap-2 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="size-9 bg-violet-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-violet-600 text-[18px]">login</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-600 text-center">Log Masuk &amp; Keluar</p>
                </div>
                <div class="flex flex-col items-center gap-2 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="size-9 bg-violet-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-violet-600 text-[18px]">edit_note</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-600 text-center">Perubahan Data</p>
                </div>
                <div class="flex flex-col items-center gap-2 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="size-9 bg-violet-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-violet-600 text-[18px]">manage_history</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-600 text-center">Riwayat Aksi</p>
                </div>
            </div>

            <!-- Coming Soon Badge -->
            <div class="mt-8 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-violet-200 cursor-default select-none">
                <span class="material-symbols-outlined text-[16px]">construction</span>
                Dalam Pengembangan
            </div>

        </div>
    </div>

    <!-- Info Note -->
    <div class="flex items-start gap-3 p-4 bg-violet-50 border border-violet-200 rounded-xl">
        <span class="material-symbols-outlined text-violet-500 text-[18px] mt-0.5 flex-shrink-0">info</span>
        <div>
            <p class="text-sm font-semibold text-violet-800">Catatan Pengembangan</p>
            <p class="text-sm text-violet-700 mt-0.5">
                Audit log akan mencatat setiap tindakan kritis seperti: penambahan/penghapusan admin,
                perubahan status order, verifikasi pembayaran, dan aksi sistem lainnya secara real-time.
            </p>
        </div>
    </div>

</div>
@endsection
