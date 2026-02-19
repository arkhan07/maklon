@extends('layouts.sidebar')
@section('title', 'Profile')
@section('breadcrumb')<span class="text-primary font-medium">Profile</span>@endsection

@section('content')
<div class="p-8 max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Profile Saya</h2>
        <p class="text-slate-500 text-sm">Kelola informasi akun Anda</p>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Profile Info -->
    <form method="POST" action="{{ route('profile.update') }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf @method('PUT')
        <h3 class="font-bold text-slate-800 pb-4 border-b border-slate-100">Informasi Pribadi</h3>

        <!-- Avatar -->
        <div class="flex items-center gap-4">
            <div class="size-16 rounded-full bg-primary flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                <p class="text-sm text-slate-400">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="name">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="block w-full px-4 py-3 border @error('name') border-red-400 @else border-slate-200 @enderror rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="email">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="block w-full px-4 py-3 border @error('email') border-red-400 @else border-slate-200 @enderror rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="company_name">Nama Perusahaan</label>
                <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-lg font-bold hover:bg-primary/90 transition-all">Simpan Perubahan</button>
        </div>
    </form>

    <!-- Change Password -->
    <form method="POST" action="{{ route('profile.password') }}" class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf @method('PUT')
        <h3 class="font-bold text-slate-800 pb-4 border-b border-slate-100">Ubah Password</h3>

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700" for="current_password">Password Saat Ini <span class="text-red-500">*</span></label>
            <input type="password" id="current_password" name="current_password" required
                class="block w-full px-4 py-3 border @error('current_password') border-red-400 @else border-slate-200 @enderror rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
            @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="new_password">Password Baru <span class="text-red-500">*</span></label>
                <input type="password" id="new_password" name="password" required
                    class="block w-full px-4 py-3 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-1.5">
                <label class="text-sm font-semibold text-slate-700" for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
            </div>
        </div>

        <button type="submit" class="bg-slate-800 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-slate-700 transition-all">Ubah Password</button>
    </form>
</div>
@endsection
