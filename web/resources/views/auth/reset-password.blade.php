@extends('layouts.app')

@section('title', 'Reset Password')

@push('styles')
<style>
    .floating-label-group { position: relative; }
    .floating-label-group input:focus ~ label,
    .floating-label-group input:not(:placeholder-shown) ~ label {
        top: -0.5rem; left: 0.75rem; font-size: 0.75rem;
        color: #001f3d; background-color: white; padding: 0 0.25rem;
    }
    .floating-label-group label {
        position: absolute; top: 1rem; left: 1rem;
        transition: all 0.2s ease-out; pointer-events: none; color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-[420px] bg-white dark:bg-slate-900 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 dark:border-slate-800 p-8 md:p-10">

        <!-- Header -->
        <div class="flex flex-col items-center mb-8">
            <div class="size-14 mb-4 bg-emerald-50 text-emerald-600 flex items-center justify-center rounded-full">
                <span class="material-symbols-outlined text-3xl">lock_open</span>
            </div>
            <h1 class="text-2xl font-bold text-primary dark:text-white tracking-tight text-center">Reset Password</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2 text-center">Buat password baru yang kuat untuk akun Anda.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-600 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">error</span>
                    {{ $error }}
                </p>
            @endforeach
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email (hidden but pre-filled) -->
            <div class="floating-label-group">
                <input
                    class="block w-full px-4 py-3.5 text-slate-900 dark:text-white bg-transparent border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none"
                    id="email"
                    name="email"
                    placeholder=" "
                    required
                    type="email"
                    value="{{ $email ?? old('email') }}"
                    autocomplete="email"
                    readonly
                />
                <label class="text-sm font-medium" for="email">Email Address</label>
            </div>

            <!-- New Password -->
            <div class="floating-label-group">
                <input
                    class="block w-full px-4 py-3.5 text-slate-900 dark:text-white bg-transparent border @error('password') border-red-400 @else border-slate-200 dark:border-slate-700 @enderror rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none"
                    id="password"
                    name="password"
                    placeholder=" "
                    required
                    type="password"
                    autocomplete="new-password"
                />
                <label class="text-sm font-medium" for="password">Password Baru</label>
                <button class="absolute right-3 top-3.5 text-slate-400 hover:text-primary transition-colors" type="button" id="togglePassword">
                    <span class="material-symbols-outlined text-xl" id="eyeIcon1">visibility</span>
                </button>
            </div>

            <!-- Confirm Password -->
            <div class="floating-label-group">
                <input
                    class="block w-full px-4 py-3.5 text-slate-900 dark:text-white bg-transparent border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder=" "
                    required
                    type="password"
                    autocomplete="new-password"
                />
                <label class="text-sm font-medium" for="password_confirmation">Konfirmasi Password Baru</label>
                <button class="absolute right-3 top-3.5 text-slate-400 hover:text-primary transition-colors" type="button" id="toggleConfirm">
                    <span class="material-symbols-outlined text-xl" id="eyeIcon2">visibility</span>
                </button>
            </div>

            <button
                class="w-full bg-primary text-white py-3.5 rounded-lg font-bold text-sm tracking-wide shadow-lg shadow-primary/20 hover:bg-primary/90 active:scale-[0.98] transition-all"
                type="submit"
            >
                Reset Password
            </button>
        </form>
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none opacity-50">
        <div class="absolute top-[10%] left-[10%] w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[10%] right-[10%] w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    </div>
    <div class="fixed inset-0 -z-20 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#001f3d 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
</div>
@endsection

@push('scripts')
<script>
    function toggleVisibility(btnId, inputId, iconId) {
        document.getElementById(btnId).addEventListener('click', function() {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
        });
    }
    toggleVisibility('togglePassword', 'password', 'eyeIcon1');
    toggleVisibility('toggleConfirm', 'password_confirmation', 'eyeIcon2');
</script>
@endpush
