@extends('layouts.super_admin')
@section('title', 'Kelola Admin')
@section('breadcrumb', 'Kelola Admin')

@section('content')
<div class="p-8 space-y-6">

    <!-- Page Heading -->
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Kelola Admin</h2>
            <p class="text-slate-500 text-sm mt-1">Tambah, lihat, dan hapus akun administrator platform</p>
        </div>
        <button onclick="document.getElementById('modal-add-admin').classList.remove('hidden')"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-md shadow-violet-200">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            Tambah Admin
        </button>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
        <span class="material-symbols-outlined text-green-500 text-[18px]">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
        <span class="material-symbols-outlined text-red-500 text-[18px]">error</span>
        {{ session('error') }}
    </div>
    @endif

    <!-- Admins Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Daftar Administrator</h3>
            <p class="text-xs text-slate-400 mt-0.5">
                Total {{ $admins->total() }} administrator terdaftar
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide w-10">#</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Role</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Bergabung</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admins as $index => $admin)
                    <tr class="hover:bg-slate-50/50 transition-colors">

                        {{-- No --}}
                        <td class="px-6 py-4 text-slate-400 text-xs font-mono">
                            {{ $admins->firstItem() + $index }}
                        </td>

                        {{-- Name --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0
                                            {{ $admin->role === 'super_admin' ? 'bg-violet-100 text-violet-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $admin->name }}</p>
                                    @if($admin->id === auth()->id())
                                    <span class="text-[10px] text-violet-500 font-semibold">(Anda)</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4 text-slate-500">{{ $admin->email }}</td>

                        {{-- Role Badge --}}
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

                        {{-- Created At --}}
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $admin->created_at->format('d M Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            @if($admin->id !== auth()->id())
                            <form method="POST"
                                  action="{{ route('super_admin.admins.destroy', $admin) }}"
                                  onsubmit="return confirm('Hapus admin {{ addslashes($admin->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 rounded-lg transition-all duration-150">
                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                    Hapus
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-slate-300 italic">—</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="size-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">manage_accounts</span>
                                </div>
                                <div>
                                    <p class="text-slate-500 font-medium">Belum ada admin terdaftar</p>
                                    <p class="text-slate-400 text-sm mt-0.5">Gunakan tombol "Tambah Admin" untuk memulai</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($admins->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-400">
                Menampilkan {{ $admins->firstItem() }}–{{ $admins->lastItem() }} dari {{ $admins->total() }} admin
            </p>
            <div class="flex items-center gap-1">
                {{-- Previous --}}
                @if($admins->onFirstPage())
                    <span class="px-3 py-1.5 text-xs text-slate-300 border border-slate-200 rounded-lg cursor-not-allowed">
                        <span class="material-symbols-outlined text-[14px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $admins->previousPageUrl() }}"
                       class="px-3 py-1.5 text-xs text-slate-500 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                        <span class="material-symbols-outlined text-[14px]">chevron_left</span>
                    </a>
                @endif

                {{-- Pages --}}
                @foreach($admins->getUrlRange(1, $admins->lastPage()) as $page => $url)
                    @if($page == $admins->currentPage())
                        <span class="px-3 py-1.5 text-xs font-semibold text-white bg-violet-600 rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1.5 text-xs text-slate-500 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($admins->hasMorePages())
                    <a href="{{ $admins->nextPageUrl() }}"
                       class="px-3 py-1.5 text-xs text-slate-500 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    </a>
                @else
                    <span class="px-3 py-1.5 text-xs text-slate-300 border border-slate-200 rounded-lg cursor-not-allowed">
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<!-- ============================================================ -->
<!-- Add Admin Modal                                              -->
<!-- ============================================================ -->
<div id="modal-add-admin"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     onclick="if(event.target===this) this.classList.add('hidden')">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

    {{-- Panel --}}
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="size-9 bg-violet-100 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-violet-600 text-[20px]">person_add</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Tambah Admin Baru</h3>
                    <p class="text-xs text-slate-400">Isi data administrator yang akan ditambahkan</p>
                </div>
            </div>
            <button onclick="document.getElementById('modal-add-admin').classList.add('hidden')"
                    class="size-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('super_admin.admins.store') }}" class="p-6 space-y-4">
            @csrf

            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                <ul class="text-xs text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-start gap-1.5">
                            <span class="material-symbols-outlined text-[13px] mt-0.5 flex-shrink-0">error</span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Name --}}
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">
                    Nama Lengkap
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       placeholder="Contoh: John Doe"
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('name') border-red-300 ring-1 ring-red-300 @enderror">
            </div>

            {{-- Email --}}
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">
                    Alamat Email
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       placeholder="admin@maklon.id"
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('email') border-red-300 ring-1 ring-red-300 @enderror">
            </div>

            {{-- Password --}}
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">
                    Password
                </label>
                <div class="relative">
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           placeholder="Minimal 8 karakter"
                           class="w-full px-4 py-2.5 pr-10 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('password') border-red-300 ring-1 ring-red-300 @enderror">
                    <button type="button"
                            onclick="const f=document.getElementById('password');f.type=f.type==='password'?'text':'password'"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                    </button>
                </div>
            </div>

            {{-- Password Confirmation --}}
            <div class="space-y-1.5">
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">
                    Konfirmasi Password
                </label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       required
                       placeholder="Ulangi password"
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow">
            </div>

            {{-- Role --}}
            <div class="space-y-1.5">
                <label for="role" class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">
                    Role
                </label>
                <select id="role"
                        name="role"
                        required
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-shadow @error('role') border-red-300 ring-1 ring-red-300 @enderror">
                    <option value="" disabled selected>Pilih role…</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                </select>
                <p class="text-[11px] text-slate-400 mt-1">
                    Super Admin memiliki akses penuh termasuk halaman ini.
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-add-admin').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-violet-600 hover:bg-violet-700 rounded-xl transition-colors shadow-md shadow-violet-200 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">person_add</span>
                    Tambah Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Re-open modal on validation error so user can see the errors
    @if($errors->any())
        document.getElementById('modal-add-admin').classList.remove('hidden');
    @endif

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('modal-add-admin').classList.add('hidden');
        }
    });
</script>
@endpush
