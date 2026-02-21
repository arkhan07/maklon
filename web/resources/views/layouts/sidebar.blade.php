<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard') | Maklon.id</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..700;1,14..32,300..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":          "#001f3d",
                        "primary-mid":      "#003366",
                        "background-light": "#f5f7fa",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                    boxShadow: {
                        "card":  "0 1px 3px 0 rgb(0 0 0 / .07), 0 1px 2px -1px rgb(0 0 0 / .04)",
                        "card-hover": "0 4px 16px 0 rgb(0 0 0 / .10)",
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .ms-filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .nav-active .ms-nav { font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light text-slate-900 font-display antialiased">
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 flex flex-col h-full flex-shrink-0"
           style="background: linear-gradient(180deg, #001f3d 0%, #002952 100%);">
        <!-- Logo -->
        <div class="px-5 py-5 flex items-center gap-3">
            <div class="size-9 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-xl ms-filled" style="color:#001f3d;">factory</span>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white tracking-tight leading-tight">Maklon.id</h1>
                <p class="text-[10px] text-white/40 font-medium">Platform Maklon Kosmetik</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-2 space-y-0.5 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all nav-active
                      {{ request()->routeIs('dashboard') ? 'bg-white/12 text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">dashboard</span>
                <span>Overview</span>
            </a>

            <div class="pt-4 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Order</p>
            </div>

            <a href="{{ route('orders.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('orders.create') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">add_circle</span>
                <span>Buat Order Baru</span>
            </a>

            <a href="{{ route('orders.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('orders.index','orders.show') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">package_2</span>
                <span>Order Saya</span>
            </a>

            <a href="{{ route('tracking.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('tracking.*') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">local_shipping</span>
                <span>Tracking Produksi</span>
            </a>

            <div class="pt-4 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Keuangan</p>
            </div>

            <a href="{{ route('invoices.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('invoices.*') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">description</span>
                <span>Invoice</span>
            </a>

            <a href="{{ route('payments.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('payments.*') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">payments</span>
                <span>Pembayaran</span>
            </a>

            <div class="pt-4 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Layanan</p>
            </div>

            <a href="{{ route('layanan.legalitas') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('layanan.legalitas') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">gavel</span>
                <span>PT & Legalitas</span>
            </a>

            <div class="pt-4 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Akun</p>
            </div>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('profile.*') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">person</span>
                <span>Profil</span>
            </a>

            <a href="{{ route('settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('settings.*') ? 'bg-white/12 text-white nav-active' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">settings</span>
                <span>Settings</span>
            </a>
        </nav>

        <!-- User Footer -->
        <div class="p-3 border-t border-white/10">
            <div class="flex items-center gap-3 px-2 py-2">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="size-9 rounded-full border-2 border-white/20 object-cover" alt="{{ auth()->user()->name }}"/>
                @else
                    <div class="size-9 rounded-full bg-white/15 border border-white/20 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex flex-col min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->company_name ?: auth()->user()->name }}</p>
                    <p class="text-[10px] text-white/45 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-white/45 hover:text-white hover:bg-white/8 transition-colors text-xs font-medium">
                    <span class="material-symbols-outlined text-sm">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="h-14 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 z-10 flex-shrink-0 shadow-[0_1px_0_0_rgb(0_0_0/.04)]">
            <div class="flex items-center gap-4">
                <nav class="flex items-center text-sm text-slate-400 gap-1.5">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors font-medium">Home</a>
                    @hasSection('breadcrumb')
                        <span class="material-symbols-outlined text-[16px] text-slate-300">chevron_right</span>
                        @yield('breadcrumb')
                    @endif
                </nav>
            </div>
            <div class="flex items-center gap-2">
                <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors relative">
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                </button>
                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                    <div class="size-7 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto">
            @yield('content')
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
