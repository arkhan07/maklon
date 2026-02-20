<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Super Admin') | Maklon.id Super Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#001f3d",
                        "violet-brand": "#7c3aed",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .fill-icon { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 font-display">
<div class="flex h-screen overflow-hidden">

    <!-- Super Admin Sidebar -->
    <aside class="w-64 bg-slate-950 text-white flex flex-col h-full flex-shrink-0">

        <!-- Logo -->
        <div class="p-6 flex items-center gap-3 border-b border-white/5">
            <div class="size-9 bg-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-900/40">
                <span class="material-symbols-outlined text-xl text-white fill-icon">shield_person</span>
            </div>
            <div>
                <h1 class="text-sm font-bold tracking-tight text-white">Maklon.id</h1>
                <span class="inline-flex items-center gap-1 bg-violet-600/20 text-violet-400 text-[9px] font-bold uppercase tracking-widest px-1.5 py-0.5 rounded">
                    <span class="size-1 rounded-full bg-violet-400 inline-block"></span>
                    Super Admin
                </span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <!-- Dashboard -->
            <a href="{{ route('super_admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                      {{ request()->routeIs('super_admin.dashboard')
                         ? 'bg-violet-600 text-white shadow-md shadow-violet-900/30'
                         : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <div class="pt-5 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest text-white/25 font-bold">Manajemen</p>
            </div>

            <!-- Kelola Admin -->
            <a href="{{ route('super_admin.admins.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                      {{ request()->routeIs('super_admin.admins.*')
                         ? 'bg-violet-600 text-white shadow-md shadow-violet-900/30'
                         : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                <span class="text-sm font-medium">Kelola Admin</span>
            </a>

            <!-- Laporan -->
            <a href="{{ route('super_admin.reports.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                      {{ request()->routeIs('super_admin.reports.*')
                         ? 'bg-violet-600 text-white shadow-md shadow-violet-900/30'
                         : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">bar_chart_4_bars</span>
                <span class="text-sm font-medium">Laporan</span>
            </a>

            <div class="pt-5 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest text-white/25 font-bold">Sistem</p>
            </div>

            <!-- Audit Log -->
            <a href="{{ route('super_admin.audit.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                      {{ request()->routeIs('super_admin.audit.*')
                         ? 'bg-violet-600 text-white shadow-md shadow-violet-900/30'
                         : 'text-white/55 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[20px]">policy</span>
                <span class="text-sm font-medium">Audit Log</span>
            </a>

        </nav>

        <!-- User Footer -->
        <div class="p-3 border-t border-white/5">
            <div class="flex items-center gap-3 px-2 py-2 mb-1 rounded-lg">
                <div class="size-9 rounded-full bg-violet-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 ring-2 ring-violet-500/30">
                    {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                    <p class="text-[10px] text-violet-400 font-semibold">Super Admin</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-white/45 hover:bg-white/5 hover:text-white transition-colors text-sm group">
                    <span class="material-symbols-outlined text-[18px] group-hover:text-red-400 transition-colors">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Header / Breadcrumb -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10 flex-shrink-0">
            <nav class="flex items-center text-sm text-slate-500 gap-2">
                <a href="{{ route('super_admin.dashboard') }}"
                   class="flex items-center gap-1.5 hover:text-violet-600 transition-colors font-medium">
                    <span class="material-symbols-outlined text-[16px]">shield_person</span>
                    Super Admin
                </a>
                @hasSection('breadcrumb')
                    <span class="text-slate-300">
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    </span>
                    <span class="text-slate-700 font-medium">@yield('breadcrumb')</span>
                @endif
            </nav>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-violet-700 bg-violet-50 border border-violet-200 px-3 py-1 rounded-full">
                    <span class="size-1.5 rounded-full bg-violet-500 inline-block"></span>
                    Super Admin Mode
                </span>
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-slate-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    Lihat sebagai User
                </a>
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
