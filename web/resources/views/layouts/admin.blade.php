<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin') | Maklon.id Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..700;1,14..32,300..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary":     "#001f3d",
                        "primary-mid": "#003366",
                        "accent":      "#f59e0b",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                    boxShadow: {
                        "card":  "0 1px 3px 0 rgb(0 0 0 / .08), 0 1px 2px -1px rgb(0 0 0 / .05)",
                        "card-hover": "0 4px 12px 0 rgb(0 0 0 / .10), 0 2px 4px -1px rgb(0 0 0 / .06)",
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .ms-filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .nav-active { background: rgba(255,255,255,.12); }
        .nav-active .ms-nav { font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-display antialiased">
<div class="flex h-screen overflow-hidden">

    <!-- Admin Sidebar -->
    <aside class="w-64 flex flex-col h-full flex-shrink-0 relative"
           style="background: linear-gradient(180deg, #001f3d 0%, #002a52 100%);">
        <!-- Logo -->
        <div class="px-5 py-5 flex items-center gap-3 border-b border-white/8">
            <div class="size-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <span class="material-symbols-outlined text-xl text-white ms-filled">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-sm font-bold text-white tracking-tight leading-tight">Maklon.id</h1>
                <p class="text-[10px] font-bold uppercase tracking-widest" style="color:#f59e0b;">Admin Panel</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all group
                      {{ request()->routeIs('admin.dashboard') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">dashboard</span>
                <span>Dashboard</span>
            </a>

            <div class="pt-5 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Manajemen</p>
            </div>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all group
                      {{ request()->routeIs('admin.orders.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">package_2</span>
                <span class="flex-1">Kelola Order</span>
                @php $pendingOrders = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingOrders > 0)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full text-slate-900"
                      style="background:#f59e0b;">{{ $pendingOrders }}</span>
                @endif
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('admin.users.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">group</span>
                <span>Kelola User</span>
            </a>

            <a href="{{ route('admin.verifikasi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all group
                      {{ request()->routeIs('admin.verifikasi.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">verified_user</span>
                <span class="flex-1">Verifikasi</span>
                @php $pendingVerif = \App\Models\User::where('verification_status','pending')->count(); @endphp
                @if($pendingVerif > 0)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-500 text-white">{{ $pendingVerif }}</span>
                @endif
            </a>

            <a href="{{ route('admin.mou.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all group
                      {{ request()->routeIs('admin.mou.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">description</span>
                <span class="flex-1">Verifikasi MOU</span>
                @php $pendingMou = \App\Models\MouDocument::where('status','signed_uploaded')->count(); @endphp
                @if($pendingMou > 0)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-500 text-white">{{ $pendingMou }}</span>
                @endif
            </a>

            <a href="{{ route('admin.invoices.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('admin.invoices.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">receipt_long</span>
                <span>Invoice</span>
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all group
                      {{ request()->routeIs('admin.payments.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">payments</span>
                <span class="flex-1">Verifikasi Bayar</span>
                @php $pendingPay = \App\Models\Payment::where('status','pending')->count(); @endphp
                @if($pendingPay > 0)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-500 text-white">{{ $pendingPay }}</span>
                @endif
            </a>

            <div class="pt-5 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Master Data</p>
            </div>

            <a href="{{ route('admin.produk.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('admin.produk.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">inventory_2</span>
                <span>Kelola Produk</span>
            </a>

            <a href="{{ route('admin.material.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('admin.material.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">science</span>
                <span>Bahan Baku</span>
            </a>

            <a href="{{ route('admin.kemasan.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('admin.kemasan.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">inventory</span>
                <span>Kemasan</span>
            </a>

            <div class="pt-5 pb-1.5 px-3">
                <p class="text-[9px] uppercase tracking-widest font-bold text-white/25">Sistem</p>
            </div>

            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
                      {{ request()->routeIs('admin.settings.*') ? 'nav-active text-white' : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                <span class="material-symbols-outlined text-[20px] ms-nav">settings</span>
                <span>Pengaturan</span>
            </a>
        </nav>

        <!-- User Footer -->
        <div class="p-3 border-t border-white/8">
            <div class="flex items-center gap-3 px-2 py-2 mb-1">
                <div class="size-9 rounded-full flex items-center justify-center text-slate-900 text-sm font-bold flex-shrink-0"
                     style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold" style="color:#f59e0b;">Administrator</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}"
                   class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-white/50 hover:text-white hover:bg-white/8 transition-colors text-xs">
                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                    User View
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-white/50 hover:text-white hover:bg-white/8 transition-colors text-xs">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="h-14 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 z-10 flex-shrink-0 shadow-[0_1px_0_0_rgb(0_0_0/.04)]">
            <nav class="flex items-center text-sm text-slate-400 gap-1.5">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors font-medium">Admin</a>
                @hasSection('breadcrumb')
                    <span class="material-symbols-outlined text-[16px] text-slate-300">chevron_right</span>
                    @yield('breadcrumb')
                @endif
            </nav>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full font-medium">
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto bg-slate-50">
            @yield('content')
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
