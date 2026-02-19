@extends('layouts.admin')
@section('title', 'Detail User')
@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors">Kelola User</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">{{ $user->name }}</span>
@endsection

@section('content')
<div class="p-8 max-w-3xl mx-auto space-y-6">
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- User Profile Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <div class="size-16 rounded-full bg-primary flex items-center justify-center text-white text-2xl font-bold">{{ strtoupper(substr($user->name,0,1)) }}</div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                    @if($user->company_name)<p class="text-slate-400 text-sm">{{ $user->company_name }}</p>@endif
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf @method('PUT')
                    <button type="submit" class="text-sm {{ $user->is_active ? 'text-red-500' : 'text-emerald-600' }} font-semibold hover:underline">
                        {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </form>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-3 gap-4 pt-6 border-t border-slate-100">
            <div class="text-center"><p class="text-2xl font-black text-primary">{{ $user->orders->count() }}</p><p class="text-xs text-slate-400 mt-0.5">Total Order</p></div>
            <div class="text-center"><p class="text-2xl font-black text-primary">{{ $user->orders->where('status','done')->count() }}</p><p class="text-xs text-slate-400 mt-0.5">Order Selesai</p></div>
            <div class="text-center"><p class="text-2xl font-black text-primary">{{ $user->created_at->format('M Y') }}</p><p class="text-xs text-slate-400 mt-0.5">Bergabung</p></div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100"><h3 class="font-bold text-slate-800">Order Terbaru</h3></div>
        <div class="divide-y divide-slate-100">
            @forelse($user->orders as $order)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-primary hover:underline">#{{ $order->order_number }}</a>
                    <p class="text-xs text-slate-400">{{ $order->product_name }} · {{ $order->created_at->format('d M Y') }}</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->statusColor() }}">{{ $order->statusLabel() }}</span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-sm text-slate-400">Belum ada order</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
