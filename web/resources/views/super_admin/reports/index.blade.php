@extends('layouts.super_admin')
@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
<div class="p-8 space-y-8">

    <!-- Page Heading -->
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Laporan Platform</h2>
            <p class="text-slate-500 text-sm mt-1">Ringkasan performa dan pendapatan Maklon.id</p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-violet-700 bg-violet-50 border border-violet-200 px-3 py-1.5 rounded-full">
            <span class="material-symbols-outlined text-[14px]">calendar_month</span>
            {{ now()->isoFormat('MMMM YYYY') }}
        </span>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-violet-600 to-violet-800 rounded-2xl shadow-lg shadow-violet-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-violet-200 uppercase tracking-wide">Total Pendapatan</p>
                    <h3 class="text-xl font-bold text-white mt-1.5 leading-tight truncate">
                        Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-violet-300 mt-1">Sepanjang waktu</p>
                </div>
                <div class="p-3 bg-white/15 rounded-xl flex-shrink-0 ml-3">
                    <span class="material-symbols-outlined text-2xl text-white">account_balance_wallet</span>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group hover:border-violet-200 hover:shadow-md transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Bulan Ini</p>
                    <h3 class="text-xl font-bold text-slate-900 mt-1.5 leading-tight truncate">
                        Rp {{ number_format($stats['this_month'], 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">{{ now()->isoFormat('MMMM YYYY') }}</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors flex-shrink-0 ml-3">
                    <span class="material-symbols-outlined text-2xl text-emerald-600">trending_up</span>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group hover:border-violet-200 hover:shadow-md transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Order</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-1.5">
                        {{ number_format($stats['total_orders']) }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Semua transaksi</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-xl group-hover:bg-amber-100 transition-colors flex-shrink-0 ml-3">
                    <span class="material-symbols-outlined text-2xl text-amber-600">package_2</span>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group hover:border-violet-200 hover:shadow-md transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pelanggan</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-1.5">
                        {{ number_format($stats['total_customers']) }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Pengguna terdaftar</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors flex-shrink-0 ml-3">
                    <span class="material-symbols-outlined text-2xl text-blue-600">group</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Monthly Revenue Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="size-9 bg-violet-100 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-violet-600 text-[20px]">bar_chart_4_bars</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Pendapatan per Bulan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Rekapitulasi revenue bulanan platform</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">#</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Periode</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pendapatan</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Proporsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $grandTotal = collect($monthlyRevenue)->sum('total');
                        $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp

                    @forelse($monthlyRevenue as $index => $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">

                        {{-- No --}}
                        <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                            {{ $index + 1 }}
                        </td>

                        {{-- Period --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 bg-violet-50 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-violet-500 text-[18px]">calendar_month</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">
                                        {{ $months[(int)$row['month']] ?? $row['month'] }} {{ $row['year'] }}
                                    </p>
                                    <p class="text-[11px] text-slate-400">{{ $row['year'] }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-slate-800">
                                Rp {{ number_format($row['total'], 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Proportion Bar --}}
                        <td class="px-6 py-4 text-right">
                            @php
                                $pct = $grandTotal > 0 ? round(($row['total'] / $grandTotal) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-24 bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-violet-500 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-500 w-10 text-right">{{ $pct }}%</span>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="size-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">bar_chart_4_bars</span>
                                </div>
                                <div>
                                    <p class="text-slate-500 font-medium">Belum ada data pendapatan</p>
                                    <p class="text-slate-400 text-sm mt-0.5">Data akan muncul setelah ada transaksi yang selesai</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                @if(count($monthlyRevenue) > 0)
                {{-- Footer: Grand Total --}}
                <tfoot>
                    <tr class="bg-violet-50 border-t-2 border-violet-200">
                        <td colspan="2" class="px-6 py-4">
                            <span class="text-sm font-bold text-violet-800">Total Keseluruhan</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-violet-800">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-xs font-bold text-violet-600">100%</span>
                        </td>
                    </tr>
                </tfoot>
                @endif

            </table>
        </div>
    </div>

</div>
@endsection
