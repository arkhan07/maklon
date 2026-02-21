@extends('layouts.app')

@section('title', 'Daftar Akun')

@push('styles')
<style>
    .fl-group { position: relative; }
    .fl-group input:focus ~ label,
    .fl-group input:not(:placeholder-shown) ~ label,
    .fl-group select:focus ~ label,
    .fl-group select:not([value=""]):valid ~ label {
        top: -0.45rem;
        left: 0.75rem;
        font-size: 0.7rem;
        color: #001f3d;
        background: white;
        padding: 0 0.25rem;
        font-weight: 600;
    }
    .fl-group label {
        position: absolute;
        top: 0.9rem;
        left: 1rem;
        font-size: 0.875rem;
        color: #94a3b8;
        pointer-events: none;
        transition: all 0.15s ease-out;
        z-index: 10;
        background: transparent;
    }
    .fl-group input, .fl-group select {
        padding-top: 0.875rem;
        padding-bottom: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 py-10">

    <div class="w-full max-w-[460px]">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-slate-100 p-8 md:p-10">

            <!-- Header -->
            <div class="flex flex-col items-center mb-7">
                <div class="size-12 mb-4 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-3xl">factory</span>
                </div>
                <h1 class="text-2xl font-bold text-primary tracking-tight">Buat Akun Baru</h1>
                <p class="text-slate-500 text-sm mt-1">Mulai perjalanan brand kosmetik Anda</p>
            </div>

            <!-- Errors -->
            @if ($errors->any())
            <div class="mb-5 p-3.5 bg-red-50 border border-red-200 rounded-xl">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">error</span>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
            @endif

            <!-- Google -->
            <a href="{{ route('auth.google') }}"
               class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 transition-colors text-slate-700 text-sm font-medium mb-6">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Daftar dengan Google
            </a>

            <!-- Divider -->
            <div class="relative flex items-center mb-6">
                <div class="flex-grow border-t border-slate-100"></div>
                <span class="flex-shrink mx-4 text-[11px] text-slate-400 uppercase tracking-widest font-medium">Atau dengan email</span>
                <div class="flex-grow border-t border-slate-100"></div>
            </div>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama -->
                <div class="fl-group">
                    <input
                        class="block w-full px-4 border @error('name') border-red-400 @else border-slate-200 @enderror rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none bg-transparent"
                        id="name" name="name" placeholder=" " required type="text"
                        value="{{ old('name') }}" autocomplete="name"
                    />
                    <label for="name">Nama Lengkap</label>
                </div>

                <!-- Email -->
                <div class="fl-group">
                    <input
                        class="block w-full px-4 border @error('email') border-red-400 @else border-slate-200 @enderror rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none bg-transparent"
                        id="email" name="email" placeholder=" " required type="email"
                        value="{{ old('email') }}" autocomplete="email"
                    />
                    <label for="email">Alamat Email</label>
                </div>

                <!-- Telepon -->
                <div class="fl-group">
                    <input
                        class="block w-full px-4 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none bg-transparent"
                        id="phone" name="phone" placeholder=" " type="tel"
                        value="{{ old('phone') }}"
                    />
                    <label for="phone">Nomor Telepon <span class="text-slate-300">(opsional)</span></label>
                </div>

                <!-- Perusahaan -->
                <div class="fl-group">
                    <input
                        class="block w-full px-4 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none bg-transparent"
                        id="company_name" name="company_name" placeholder=" " type="text"
                        value="{{ old('company_name') }}"
                    />
                    <label for="company_name">Nama Perusahaan <span class="text-slate-300">(opsional)</span></label>
                </div>

                <!-- Password -->
                <div class="fl-group">
                    <input
                        class="block w-full px-4 pr-11 border @error('password') border-red-400 @else border-slate-200 @enderror rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none bg-transparent"
                        id="password" name="password" placeholder=" " required type="password"
                        autocomplete="new-password"
                    />
                    <label for="password">Password</label>
                    <button type="button" id="togglePass"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl" id="eyePass">visibility</span>
                    </button>
                </div>

                <!-- Konfirmasi Password -->
                <div class="fl-group">
                    <input
                        class="block w-full px-4 pr-11 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all appearance-none bg-transparent"
                        id="password_confirmation" name="password_confirmation" placeholder=" " required type="password"
                        autocomplete="new-password"
                    />
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <button type="button" id="togglePassConf"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl" id="eyeConf">visibility</span>
                    </button>
                </div>

                <!-- Terms -->
                <label class="flex items-start gap-3 cursor-pointer group pt-1">
                    <input
                        class="mt-0.5 size-4 rounded border-slate-300 text-primary focus:ring-primary @error('terms') border-red-400 @enderror"
                        id="terms" name="terms" required type="checkbox"
                        {{ old('terms') ? 'checked' : '' }}
                    />
                    <span class="text-sm text-slate-500 group-hover:text-slate-700 transition-colors leading-snug">
                        Saya menyetujui
                        <a class="text-primary font-semibold hover:underline" href="#">Syarat & Ketentuan</a>
                        dan
                        <a class="text-primary font-semibold hover:underline" href="#">Kebijakan Privasi</a>
                    </span>
                </label>

                <!-- Submit -->
                <button
                    class="w-full bg-primary text-white py-3.5 rounded-xl font-bold text-sm tracking-wide shadow-lg shadow-primary/20 hover:bg-primary/90 active:scale-[0.98] transition-all mt-2"
                    type="submit"
                >
                    Buat Akun Gratis
                </button>
            </form>

            <!-- Footer -->
            <p class="mt-7 text-center text-sm text-slate-500">
                Sudah punya akun?
                <a class="font-bold text-primary hover:underline ml-1" href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>

    <!-- Decorative bg -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none opacity-50">
        <div class="absolute top-[10%] left-[10%] w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[10%] right-[10%] w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
    </div>
    <div class="fixed inset-0 -z-20 opacity-[0.03] pointer-events-none"
         style="background-image: radial-gradient(#001f3d 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
</div>
@endsection

@push('scripts')
<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
    }
    document.getElementById('togglePass').addEventListener('click', () => togglePass('password', 'eyePass'));
    document.getElementById('togglePassConf').addEventListener('click', () => togglePass('password_confirmation', 'eyeConf'));
</script>
@endpush
