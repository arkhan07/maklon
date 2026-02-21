@extends('layouts.super_admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="p-8 space-y-8">

    <!-- Page Heading -->
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Dashboard Super Admin</h2>
            <p class="text-slate-500 text-sm mt-1">Ikhtisar menyeluruh platform Maklon.id</p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-violet-700 bg-violet-50 border border-violet-200 px-3 py-1.5 rounded-full">
            <span class="material-symbols-outlined text-[14px]">verified_user</span>
            Akses Penuh
        </span>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Total User -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start justify-between group hover:border-violet-200 hover:shadow-md transition-all duration-200">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total User</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-1.5">
                    {{ number_format($stats['total_users']) }}
                </h3>
                <p class="text-xs text-slate-400 mt-1">Pengguna terdaftar</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                <span class="material-symbols-outlined text-2xl text-blue-600">group</span>
            </div>
        </div>

        <!-- Total Admin -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start justify-between group hover:border-violet-200 hover:shadow-md transition-all duration-200">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Admin</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-1.5">
                    {{ number_format($stats['total_admins']) }}
                </h3>
                <p class="text-xs text-slate-400 mt-1">Staf administrator</p>
            </div>
            <div class="p-3 bg-violet-50 rounded-xl group-hover:bg-violet-100 transition-colors">
                <span class="material-symbols-outlined text-2xl text-violet-600">admin_panel_settings</span>
            </div>
        </div>

        <!-- Total Order -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start justify-between group hover:border-violet-200 hover:shadow-md transition-all duration-200">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Order</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-1.5">
                    {{ number_format($stats['total_orders']) }}
                </h3>
                <p class="text-xs text-slate-400 mt-1">Semua transaksi</p>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl group-hover:bg-amber-100 transition-colors">
                <span class="material-symbols-outlined text-2xl text-amber-600">package_2</span>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-violet-600 to-violet-700 rounded-2xl shadow-lg shadow-violet-200 p-6 flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-violet-200 uppercase tracking-wide">Total Revenue</p>
                <h3 class="text-2xl font-bold text-white mt-1.5 leading-tight">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </h3>
                <p class="text-xs text-violet-300 mt-1">Pendapatan platform</p>
            </div>
            <div class="p-3 bg-white/15 rounded-xl">
                <span class="material-symbols-outlined text-2xl text-white">account_balance_wallet</span>
            </div>
        </div>

    </div>

    <!-- Recent Admins Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Admin Terdaftar</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar administrator yang aktif di sistem</p>
            </div>
            <a href="{{ route('super_admin.admins.index') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-violet-600 hover:text-violet-700 transition-colors">
                Kelola Semua
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Role</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-violet-100 text-violet-700 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $admin->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $admin->email }}</td>
                        <td class="px-6 py-4">
                            @if($admin->role === 'super_admin')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-violet-100 text-violet-700">
                                    <span class="material-symbols-outlined text-[12px]">shield_person</span>
                                    Super Admin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    <span class="material-symbols-outlined text-[12px]">admin_panel_settings</span>
                                    Admin
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $admin->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-slate-300">manage_accounts</span>
                                <p class="text-slate-400 text-sm">Belum ada admin terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
