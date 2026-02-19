<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin') | Maklon.id Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { "primary": "#001f3d" },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 font-display">
<div class="flex h-screen overflow-hidden">
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col h-full flex-shrink-0">
        <div class="p-6 flex items-center gap-3 border-b border-white/5">
            <div class="size-8 bg-amber-400 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-xl text-slate-900">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-sm font-bold tracking-tight">Maklon.id</h1>
                <p class="text-[10px] text-amber-400 font-bold uppercase tracking-widest">Admin Panel</p>
            </div>
        </div>
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <div class="pt-4 pb-1">
                <p class="px-3 text-[10px] uppercase tracking-wider text-white/30 font-bold">Manajemen</p>
            </div>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('admin.orders.index') }}">
                <span class="material-symbols-outlined">package_2</span>
                <span class="text-sm font-medium">Kelola Order</span>
                @php $pendingOrders = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingOrders > 0)
                <span class="ml-auto bg-amber-400 text-slate-900 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingOrders }}</span>
                @endif
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('admin.users.index') }}">
                <span class="material-symbols-outlined">group</span>
                <span class="text-sm font-medium">Kelola User</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.invoices.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('admin.invoices.index') }}">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="text-sm font-medium">Invoice</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.payments.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('admin.payments.index') }}">
                <span class="material-symbols-outlined">payments</span>
                <span class="text-sm font-medium">Verifikasi Pembayaran</span>
                @php $pendingPay = \App\Models\Payment::where('status','pending')->count(); @endphp
                @if($pendingPay > 0)
                <span class="ml-auto bg-red-400 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingPay }}</span>
                @endif
            </a>

            <div class="pt-4 pb-1">
                <p class="px-3 text-[10px] uppercase tracking-wider text-white/30 font-bold">Sistem</p>
            </div>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }} transition-colors" href="{{ route('admin.settings.index') }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm font-medium">Pengaturan</span>
            </a>
        </nav>
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 p-2 mb-2">
                <div class="size-9 rounded-full bg-amber-400 flex items-center justify-center text-slate-900 text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-xs font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-amber-400 font-bold">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors text-sm">
                    <span class="material-symbols-outlined text-base">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10 flex-shrink-0">
            <nav class="flex text-sm text-slate-500 gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                @hasSection('breadcrumb')
                    <span class="text-slate-300">/</span>
                    @yield('breadcrumb')
                @endif
            </nav>
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-500 hover:text-primary flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-base">open_in_new</span>
                Lihat sebagai User
            </a>
        </header>
        <div class="flex-1 overflow-y-auto">
            @yield('content')
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
