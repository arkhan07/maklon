@extends('layouts.admin')
@section('title', 'Kelola Kemasan')
@section('breadcrumb') <span class="text-slate-700">Kemasan</span> @endsection

@section('content')
<div class="p-6">
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-red-600">error</span>
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-primary">Kelola Kemasan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Jenis kemasan yang tersedia untuk produk</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Form Tambah -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 h-fit">
            <h2 class="font-semibold text-gray-900 mb-4">Tambah Kemasan</h2>
            <form action="{{ route('admin.kemasan.store') }}" method="POST" class="space-y-3">
                @csrf
                @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $e)
                        <p class="text-xs text-red-600">{{ $e }}</p>
                    @endforeach
                </div>
                @endif
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Kemasan</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="cth: Botol Pump 100ml"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tipe</label>
                    <select name="type" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="botol" {{ old('type')=='botol'?'selected':'' }}>Botol</option>
                        <option value="tube" {{ old('type')=='tube'?'selected':'' }}>Tube</option>
                        <option value="sachet" {{ old('type')=='sachet'?'selected':'' }}>Sachet</option>
                        <option value="jar" {{ old('type')=='jar'?'selected':'' }}>Jar</option>
                        <option value="lainnya" {{ old('type')=='lainnya'?'selected':'' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Harga per Unit (Rp)</label>
                    <input type="number" name="price_per_unit" value="{{ old('price_per_unit') }}" min="0" step="100"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-primary" placeholder="0">
                </div>
                <button type="submit" class="w-full py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                    Tambah Kemasan
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100">
                <h2 class="font-semibold text-gray-900">Daftar Kemasan ({{ $packagings->total() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Tipe</th>
                            <th class="px-4 py-3 text-right">Harga/Unit</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($packagings as $kemasan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $kemasan->name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-xs font-medium capitalize">{{ $kemasan->type }}</span>
                            </td>
                            <td class="px-4 py-3 text-right text-slate-600">Rp {{ number_format($kemasan->price_per_unit, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('admin.kemasan.destroy', $kemasan) }}" method="POST"
                                      onsubmit="return confirm('Hapus kemasan {{ $kemasan->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-slate-400 text-sm">
                                Belum ada kemasan. Tambahkan di form sebelah kiri.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($packagings->hasPages())
            <div class="p-4 border-t border-slate-100">{{ $packagings->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
