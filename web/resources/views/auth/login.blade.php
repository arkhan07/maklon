@extends('layouts.app')

@section('title', 'Login')

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
    <!-- Main Auth Card -->
    <div class="w-full max-w-[420px] bg-white dark:bg-slate-900 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 dark:border-slate-800 p-8 md:p-10">

        <!-- Header & Logo -->
        <div class="flex flex-col items-center mb-8">
            <div class="size-12 mb-4 bg-primary text-white flex items-center justify-center rounded-lg">
                <span class="material-symbols-outlined text-3xl">factory</span>
            </div>
            <h1 class="text-2xl font-bold text-primary dark:text-white tracking-tight">Welcome back</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Access your manufacturing dashboard</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-600">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        @if (session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-600">{{ session('status') }}</p>
        </div>
        @endif

        <!-- Social Login -->
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200 text-slate-700 dark:text-slate-200 text-sm font-medium mb-6">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Continue with Google
        </a>

        <!-- Divider -->
        <div class="relative flex items-center mb-6">
            <div class="flex-grow border-t border-slate-100 dark:border-slate-800"></div>
            <span class="flex-shrink mx-4 text-xs text-slate-400 uppercase tracking-widest font-medium">Or email</span>
            <div class="flex-grow border-t border-slate-100 dark:border-slate-800"></div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="floating-label-group">
                <input
                    class="block w-full px-4 py-3.5 text-slate-900 dark:text-white bg-transparent border @error('email') border-red-400 @else border-slate-200 dark:border-slate-700 @enderror rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none"
                    id="email"
                    name="email"
                    placeholder=" "
                    required
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                />
                <label class="text-sm font-medium" for="email">Email Address</label>
            </div>

            <!-- Password -->
            <div class="floating-label-group">
                <input
                    class="block w-full px-4 py-3.5 text-slate-900 dark:text-white bg-transparent border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none"
                    id="password"
                    name="password"
                    placeholder=" "
                    required
                    type="password"
                    autocomplete="current-password"
                />
                <label class="text-sm font-medium" for="password">Password</label>
                <button
                    class="absolute right-3 top-3.5 text-slate-400 hover:text-primary transition-colors"
                    type="button"
                    id="togglePassword"
                >
                    <span class="material-symbols-outlined text-xl" id="eyeIcon">visibility</span>
                </button>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between py-1">
                <label class="flex items-center cursor-pointer group">
                    <input
                        class="size-4 rounded border-slate-300 text-primary focus:ring-primary"
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    />
                    <span class="ml-2 text-sm text-slate-500 dark:text-slate-400 group-hover:text-slate-700 transition-colors">Remember me</span>
                </label>
                <a class="text-sm font-semibold text-primary dark:text-blue-400 hover:opacity-80 transition-colors" href="#">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button
                class="w-full bg-primary text-white py-3.5 rounded-lg font-bold text-sm tracking-wide shadow-lg shadow-primary/20 hover:bg-primary/90 active:scale-[0.98] transition-all"
                type="submit"
            >
                Login to Dashboard
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Don't have an account?
                <a class="font-bold text-primary dark:text-blue-400 hover:underline" href="{{ route('register') }}">Sign up for free</a>
            </p>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none opacity-50 dark:opacity-20">
        <div class="absolute top-[10%] left-[10%] w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[10%] right-[10%] w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    </div>
    <div class="fixed inset-0 -z-20 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#001f3d 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    });
</script>
@endpush
