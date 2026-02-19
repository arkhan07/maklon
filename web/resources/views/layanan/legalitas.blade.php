@extends('layouts.sidebar')

@section('title', 'Layanan Pendirian PT & Legalitas')

@section('breadcrumb')
    <span class="text-primary font-medium">Pendirian PT & Legalitas</span>
@endsection

@section('content')
<div class="p-8 max-w-5xl mx-auto space-y-12">

    <!-- Hero Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="max-w-2xl">
            <h2 class="text-3xl font-black text-primary dark:text-white tracking-tight mb-2">Layanan Pendirian PT & Legalitas</h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg">Solusi lengkap pengurusan badan usaha dan pendaftaran merek HAKI untuk percepatan bisnis maklon Anda.</p>
        </div>
        <button class="bg-primary text-white px-6 py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 whitespace-nowrap">
            Mulai Pendaftaran
        </button>
    </div>

    <!-- Step Process Overview -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Alur Proses Legalitas</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden md:block absolute top-6 left-10 right-10 h-0.5 bg-slate-100 dark:bg-slate-800 z-0"></div>

            <!-- Step 1 -->
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="w-12 h-12 bg-white dark:bg-slate-900 border-2 border-primary rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-primary">search</span>
                </div>
                <h4 class="font-bold text-primary dark:text-white mb-1">Konsultasi Nama</h4>
                <p class="text-sm text-slate-500">Pengecekan ketersediaan nama PT sesuai KBLI terbaru.</p>
            </div>

            <!-- Step 2 -->
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="w-12 h-12 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-slate-400">description</span>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 mb-1">Akta & Notaris</h4>
                <p class="text-sm text-slate-500">Penyiapan draf akta dan proses tanda tangan notaris resmi.</p>
            </div>

            <!-- Step 3 -->
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="w-12 h-12 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-slate-400">work_outline</span>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 mb-1">Pengurusan NIB</h4>
                <p class="text-sm text-slate-500">Penerbitan Nomor Induk Berusaha melalui OSS RBA.</p>
            </div>

            <!-- Step 4 -->
            <div class="relative z-10 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="w-12 h-12 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-slate-400">verified_user</span>
                </div>
                <h4 class="font-bold text-slate-800 dark:text-slate-200 mb-1">HAKI & BPOM</h4>
                <p class="text-sm text-slate-500">Registrasi merek dan pendampingan izin edar produk.</p>
            </div>
        </div>
    </div>

    <!-- Package Options -->
    <div>
        <h3 class="text-2xl font-bold text-primary dark:text-white mb-6">Pilih Paket Layanan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Package Basic -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-8 hover:shadow-lg transition-shadow">
                <div class="flex flex-col gap-1 mb-6">
                    <h4 class="text-slate-500 text-sm font-bold uppercase tracking-wider">Paket Basic</h4>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-primary dark:text-white">IDR 5jt</span>
                        <span class="text-slate-400 text-sm">Sekali bayar</span>
                    </div>
                </div>
                <button class="w-full bg-slate-100 dark:bg-slate-800 text-primary dark:text-white py-3 rounded-lg font-bold mb-8 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    Pilih Basic
                </button>
                <ul class="space-y-4">
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        Akta Pendirian PT & SK Kemenkumham
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        NIB (Nomor Induk Berusaha)
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        NPWP Badan & SKT Pajak
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        Sertifikat Standar / Izin Usaha
                    </li>
                </ul>
            </div>

            <!-- Package Premium -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border-2 border-primary p-8 shadow-xl relative">
                <div class="absolute -top-4 right-8 bg-primary text-white text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                    Paling Populer
                </div>
                <div class="flex flex-col gap-1 mb-6">
                    <h4 class="text-slate-500 text-sm font-bold uppercase tracking-wider">Paket Premium</h4>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-primary dark:text-white">IDR 12jt</span>
                        <span class="text-slate-400 text-sm">Sekali bayar</span>
                    </div>
                </div>
                <button class="w-full bg-primary text-white py-3 rounded-lg font-bold mb-8 hover:bg-slate-800 transition-colors shadow-md">
                    Pilih Premium
                </button>
                <ul class="space-y-4">
                    <li class="flex gap-3 text-sm text-primary dark:text-blue-400 font-semibold">
                        <span class="material-symbols-outlined text-primary dark:text-blue-400 text-sm font-bold">stars</span>
                        Semua Fitur Paket Basic
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        Registrasi 1 Merek HAKI (E-Sertifikat)
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        Konsultasi Persyaratan BPOM / PIRT
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        Izin Usaha Sektoral Menengah-Tinggi
                    </li>
                    <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-emerald-500 text-sm font-bold">check</span>
                        Pendampingan Fisik Ke Notaris (Opsional)
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Dokumen & Konsultasi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <h3 class="text-xl font-bold text-primary dark:text-white mb-6">Dokumen yang Diperlukan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex gap-4 items-start">
                    <span class="material-symbols-outlined text-slate-400">badge</span>
                    <div>
                        <p class="font-bold text-sm text-slate-800 dark:text-slate-200">KTP & NPWP Pendiri</p>
                        <p class="text-xs text-slate-500 mt-0.5">Minimal 2 orang pendiri (Direktur & Komisaris)</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex gap-4 items-start">
                    <span class="material-symbols-outlined text-slate-400">home_work</span>
                    <div>
                        <p class="font-bold text-sm text-slate-800 dark:text-slate-200">Alamat Usaha</p>
                        <p class="text-xs text-slate-500 mt-0.5">Bisa menggunakan Virtual Office atau Ruko</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex gap-4 items-start">
                    <span class="material-symbols-outlined text-slate-400">account_balance</span>
                    <div>
                        <p class="font-bold text-sm text-slate-800 dark:text-slate-200">Modal Dasar & Disetor</p>
                        <p class="text-xs text-slate-500 mt-0.5">Penentuan komposisi saham antar pemodal</p>
                    </div>
                </div>
                <div class="p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex gap-4 items-start">
                    <span class="material-symbols-outlined text-slate-400">brand_family</span>
                    <div>
                        <p class="font-bold text-sm text-slate-800 dark:text-slate-200">Nama Merek (Premium)</p>
                        <p class="text-xs text-slate-500 mt-0.5">Logo dan deskripsi produk untuk HAKI</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konsultasi Box -->
        <div class="bg-primary/5 dark:bg-slate-900 border border-primary/10 dark:border-slate-800 rounded-xl p-6">
            <h3 class="font-bold text-primary dark:text-white mb-4">Butuh Konsultasi?</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                Punya struktur bisnis yang kompleks atau ingin mendirikan PT PMA (Asing)? Tim legal kami siap membantu.
            </p>
            <div class="space-y-3">
                <button class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-2.5 rounded-lg text-sm font-bold text-primary dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Tanya Admin (WA)
                </button>
                <button class="w-full py-2.5 rounded-lg text-sm font-bold text-primary dark:text-blue-400 hover:underline">
                    Lihat FAQ Lengkap
                </button>
            </div>
        </div>
    </div>

    <!-- Footer CTA -->
    <div class="bg-primary rounded-2xl p-8 md:p-12 text-center text-white overflow-hidden relative mb-4">
        <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_20%_20%,_rgba(255,255,255,0.4)_0%,_transparent_50%)]"></div>
        <h2 class="text-2xl md:text-3xl font-bold mb-4 relative z-10">Siap melegalkan bisnis maklon Anda?</h2>
        <p class="text-blue-100 mb-8 max-w-xl mx-auto relative z-10">Proses pendaftaran hanya memakan waktu 10 menit. Kami yang urus sisanya sampai dokumen di tangan Anda.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
            <button class="bg-white text-primary px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition-colors">
                Mulai Sekarang
            </button>
            <button class="bg-transparent border border-white/30 text-white px-8 py-3 rounded-lg font-bold hover:bg-white/10 transition-colors">
                Unduh Panduan PDF
            </button>
        </div>
    </div>

</div>
@endsection
