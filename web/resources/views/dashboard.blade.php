@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-white flex flex-col h-full border-r border-primary/10">
        <div class="p-6 flex items-center gap-3">
            <div class="size-8 bg-white rounded-lg flex items-center justify-center text-primary">
                <span class="material-symbols-outlined font-bold">factory</span>
            </div>
            <h1 class="text-xl font-bold tracking-tight">Maklon.id</h1>
        </div>
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white transition-colors" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm font-medium">Overview</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">add_circle</span>
                <span class="text-sm font-medium">Buat Order Baru</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">package_2</span>
                <span class="text-sm font-medium">Order Saya</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">description</span>
                <span class="text-sm font-medium">Invoice</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">payments</span>
                <span class="text-sm font-medium">Pembayaran</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">local_shipping</span>
                <span class="text-sm font-medium">Tracking</span>
            </a>
            <div class="pt-4 pb-2">
                <p class="px-3 text-[10px] uppercase tracking-wider text-white/40 font-bold">Pengaturan</p>
            </div>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">person</span>
                <span class="text-sm font-medium">Profile</span>
            </a>
        </nav>
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 p-2">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="size-9 rounded-full border-2 border-white/20" alt="{{ auth()->user()->name }}"/>
                @else
                    <div class="size-9 rounded-full bg-slate-500 border-2 border-white/20 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex flex-col min-w-0">
                    <p class="text-xs font-semibold truncate">{{ auth()->user()->company_name ?: auth()->user()->name }}</p>
                    <p class="text-[10px] text-white/50 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors text-sm">
                    <span class="material-symbols-outlined text-base">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden bg-background-light dark:bg-background-dark">
        <!-- Topbar -->
        <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 z-10">
            <div class="flex items-center gap-4">
                <nav class="flex text-sm text-slate-500 gap-2">
                    <span>Home</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-primary font-medium">Overview</span>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <button class="flex items-center gap-2 pl-4 border-l border-slate-200 ml-2">
                    <span class="text-sm font-medium text-slate-700">Help Center</span>
                    <span class="material-symbols-outlined text-slate-400">help_outline</span>
                </button>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Dashboard Overview</h2>
                    <p class="text-slate-500 text-sm">Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Berikut ringkasan akun Anda.</p>
                </div>
                <button class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-semibold transition-all shadow-sm">
                    <span class="material-symbols-outlined" style="font-size:20px">add</span>
                    Buat Order Baru
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Total Order</p>
                            <h3 class="text-2xl font-bold mt-1">0</h3>
                        </div>
                        <div class="p-2 bg-primary/5 text-primary rounded-lg">
                            <span class="material-symbols-outlined">list_alt</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1 text-[13px]">
                        <span class="text-slate-400">Belum ada order</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Diproses</p>
                            <h3 class="text-2xl font-bold mt-1">0</h3>
                        </div>
                        <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                            <span class="material-symbols-outlined">sync</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1 text-[13px]">
                        <span class="text-slate-400">Tidak ada produksi aktif</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Selesai</p>
                            <h3 class="text-2xl font-bold mt-1">0</h3>
                        </div>
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1 text-[13px]">
                        <span class="text-slate-400">Belum ada yang selesai</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Invoice Pending</p>
                            <h3 class="text-2xl font-bold mt-1">Rp 0</h3>
                        </div>
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1 text-[13px]">
                        <span class="text-slate-400">Tidak ada tagihan</span>
                    </div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/5 text-primary rounded-xl">
                        <span class="material-symbols-outlined text-3xl">waving_hand</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg">Selamat datang di Maklon.id!</h4>
                        <p class="text-slate-500 text-sm mt-1">Akun Anda sudah aktif. Mulai buat order pertama Anda untuk layanan maklon kosmetik profesional.</p>
                    </div>
                    <button class="ml-auto bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-all">
                        Mulai Sekarang
                    </button>
                </div>
            </div>

            <!-- Recent Orders Table (empty state) -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h4 class="font-bold text-slate-900">Order Terbaru</h4>
                    <button class="text-primary text-sm font-semibold hover:underline">Lihat Semua</button>
                </div>
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center size-16 bg-slate-100 rounded-full mb-4">
                        <span class="material-symbols-outlined text-3xl text-slate-400">package_2</span>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada order</p>
                    <p class="text-slate-400 text-sm mt-1">Buat order pertama Anda untuk memulai proses maklon.</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
