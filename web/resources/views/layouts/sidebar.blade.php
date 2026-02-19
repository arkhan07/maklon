<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard') | Maklon.id</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#001f3d",
                        "background-light": "#f5f7f8",
                        "background-dark": "#0f1923",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                    borderRadius: {
                        "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 font-display">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-white flex flex-col h-full border-r border-primary/10 flex-shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="size-8 bg-white rounded-lg flex items-center justify-center text-primary">
                <span class="material-symbols-outlined font-bold">factory</span>
            </div>
            <h1 class="text-xl font-bold tracking-tight">Maklon.id</h1>
        </div>
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm font-medium">Overview</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('orders.create') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="#">
                <span class="material-symbols-outlined">add_circle</span>
                <span class="text-sm font-medium">Buat Order Baru</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('orders.index') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="#">
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
                <span class="text-sm font-medium">Tracking Produksi</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-3 text-[10px] uppercase tracking-wider text-white/40 font-bold">Layanan</p>
            </div>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('layanan.legalitas') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('layanan.legalitas') }}">
                <span class="material-symbols-outlined">gavel</span>
                <span class="text-sm font-medium">Pendirian PT & Legalitas</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-3 text-[10px] uppercase tracking-wider text-white/40 font-bold">Pengaturan</p>
            </div>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('profile') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="#">
                <span class="material-symbols-outlined">person</span>
                <span class="text-sm font-medium">Profile</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm font-medium">Settings</span>
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
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 z-10 flex-shrink-0">
            <div class="flex items-center gap-4">
                <nav class="flex text-sm text-slate-500 gap-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Home</a>
                    @hasSection('breadcrumb')
                        <span class="text-slate-300">/</span>
                        @yield('breadcrumb')
                    @endif
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

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto">
            @yield('content')
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
