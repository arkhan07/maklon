@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="w-full px-6 py-4 flex items-center justify-between bg-transparent">
        <div class="flex items-center gap-2 text-primary dark:text-white">
            <div class="size-8 flex items-center justify-center bg-primary text-white rounded-lg">
                <span class="material-symbols-outlined text-xl">factory</span>
            </div>
            <h1 class="text-xl font-bold tracking-tight">Maklon.id</h1>
        </div>
        <div class="hidden md:block">
            <p class="text-sm text-slate-500">Premium Manufacturing Platform</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-8 md:py-12">
        <div class="w-full max-w-[520px] bg-white dark:bg-slate-900 rounded-xl shadow-xl shadow-primary/5 border border-slate-100 dark:border-slate-800 p-8 md:p-10">

            <!-- Heading -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-primary dark:text-white tracking-tight mb-2">Create your account</h2>
                <p class="text-slate-500 dark:text-slate-400 text-base">Start your manufacturing journey with Maklon.id today.</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">error</span>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
            @endif

            <!-- Social Register -->
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 h-12 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-slate-700 dark:text-slate-200 font-semibold mb-6">
                <svg height="20" viewBox="0 0 24 24" width="20">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Sign up with Google
            </a>

            <!-- Divider -->
            <div class="relative flex items-center mb-8">
                <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
                <span class="flex-shrink mx-4 text-slate-400 text-xs uppercase tracking-widest font-bold">Or continue with</span>
                <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Full Name -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-primary dark:text-slate-200" for="name">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <span class="material-symbols-outlined text-lg">person</span>
                        </span>
                        <input
                            class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border @error('name') border-red-400 @else border-slate-200 dark:border-slate-700 @enderror rounded-lg text-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"
                            id="name"
                            name="name"
                            placeholder="John Doe"
                            required
                            type="text"
                            value="{{ old('name') }}"
                            autocomplete="name"
                        />
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-semibold text-primary dark:text-slate-200" for="phone">Nomor Telepon</label>
                        <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Opsional</span>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <span class="material-symbols-outlined text-lg">phone</span>
                        </span>
                        <input
                            class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"
                            id="phone"
                            name="phone"
                            placeholder="08xxxxxxxxxx"
                            type="tel"
                            value="{{ old('phone') }}"
                        />
                    </div>
                </div>

                <!-- Company Name -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-semibold text-primary dark:text-slate-200" for="company_name">Nama Perusahaan</label>
                        <span class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Opsional</span>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <span class="material-symbols-outlined text-lg">corporate_fare</span>
                        </span>
                        <input
                            class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"
                            id="company_name"
                            name="company_name"
                            placeholder="PT Maju Bersama"
                            type="text"
                            value="{{ old('company_name') }}"
                        />
                    </div>
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-primary dark:text-slate-200" for="email">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <span class="material-symbols-outlined text-lg">mail</span>
                        </span>
                        <input
                            class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border @error('email') border-red-400 @else border-slate-200 dark:border-slate-700 @enderror rounded-lg text-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"
                            id="email"
                            name="email"
                            placeholder="name@company.com"
                            required
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                        />
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-primary dark:text-slate-200" for="password">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <span class="material-symbols-outlined text-lg">lock</span>
                            </span>
                            <input
                                class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border @error('password') border-red-400 @else border-slate-200 dark:border-slate-700 @enderror rounded-lg text-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                type="password"
                                autocomplete="new-password"
                            />
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-primary dark:text-slate-200" for="password_confirmation">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                                <span class="material-symbols-outlined text-lg">lock_reset</span>
                            </span>
                            <input
                                class="block w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="••••••••"
                                required
                                type="password"
                                autocomplete="new-password"
                            />
                        </div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start gap-3 py-1">
                    <div class="flex items-center h-5">
                        <input
                            class="w-4 h-4 text-primary bg-white border-slate-300 rounded focus:ring-primary focus:ring-offset-0 @error('terms') border-red-400 @enderror"
                            id="terms"
                            name="terms"
                            required
                            type="checkbox"
                            {{ old('terms') ? 'checked' : '' }}
                        />
                    </div>
                    <label class="text-sm text-slate-600 dark:text-slate-400 leading-tight" for="terms">
                        Saya menyetujui <a class="text-primary font-semibold underline underline-offset-2" href="#">Syarat & Ketentuan</a> dan <a class="text-primary font-semibold underline underline-offset-2" href="#">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- CTA Button -->
                <button
                    class="w-full h-14 text-white font-bold text-lg rounded-lg shadow-lg transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 bg-primary hover:bg-slate-800 shadow-primary/20"
                    type="submit"
                >
                    Daftar Gratis
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <!-- Footer Login Link -->
            <div class="mt-8 text-center">
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Sudah punya akun?
                    <a class="text-primary dark:text-white font-bold hover:underline underline-offset-4 ml-1" href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center">
        <p class="text-slate-400 text-xs uppercase tracking-widest font-medium">
            © {{ date('Y') }} Maklon.id Manufacturing Solutions
        </p>
    </footer>

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none opacity-40 overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-5%] right-[-5%] w-[30%] h-[30%] bg-accent-emerald/5 rounded-full blur-3xl"></div>
    </div>
</div>
@endsection
