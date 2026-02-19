@extends('layouts.admin')
@section('title', 'Pengaturan Admin')
@section('breadcrumb')<span class="text-primary font-medium">Pengaturan</span>@endsection

@section('content')
<div class="p-8 max-w-3xl mx-auto space-y-6">
    <div><h2 class="text-2xl font-bold text-slate-900">Pengaturan Sistem</h2><p class="text-slate-500 text-sm">Kelola akun admin dan konfigurasi sistem</p></div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Change Password -->
    <form method="POST" action="{{ route('admin.settings.password') }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf @method('PUT')
        <h3 class="font-bold text-slate-800 pb-4 border-b border-slate-100">Ubah Password Admin</h3>
        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Password Saat Ini <span class="text-red-500">*</span></label>
            <input type="password" name="current_password" required
                class="block w-full px-4 py-3 border @error('current_password') border-red-400 @else border-slate-200 @enderror rounded-lg focus:ring-primary focus:border-primary"/>
            @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">Password Baru <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="block w-full px-4 py-3 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-lg focus:ring-primary focus:border-primary"/>
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary focus:border-primary"/>
            </div>
        </div>
        <button type="submit" class="bg-slate-800 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-slate-700 transition-all">Ubah Password</button>
    </form>

    <!-- Daftar Admin -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100"><h3 class="font-bold text-slate-800">Daftar Administrator</h3></div>
        <div class="divide-y divide-slate-100">
            @foreach($admins as $admin)
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded-full bg-amber-400 flex items-center justify-center text-slate-900 font-bold text-sm">{{ strtoupper(substr($admin->name,0,1)) }}</div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $admin->name }} {{ $admin->id === auth()->id() ? '(Anda)' : '' }}</p>
                        <p class="text-xs text-slate-400">{{ $admin->email }}</p>
                    </div>
                </div>
                <span class="text-xs bg-amber-100 text-amber-700 font-bold px-3 py-1 rounded-full">Administrator</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tambah Admin -->
    <form method="POST" action="{{ route('admin.settings.add_admin') }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf
        <h3 class="font-bold text-slate-800 pb-4 border-b border-slate-100">Tambah Administrator Baru</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary focus:border-primary"/>
            </div>
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary focus:border-primary"/>
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2 space-y-1.5">
                <label class="text-sm font-semibold text-slate-700">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg focus:ring-primary focus:border-primary"/>
            </div>
        </div>
        <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-lg font-bold hover:bg-primary/90 transition-all">Tambah Admin</button>
    </form>
</div>
@endsection
