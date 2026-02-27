@extends('layouts.admin')
@section('title', 'Kelola Kemasan')
@section('breadcrumb')<span class="text-primary font-medium">Kelola Kemasan</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Kelola Kemasan</h2>
        <p class="text-slate-500 text-sm">Manajemen jenis kemasan produk</p>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-red-500">error</span>
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Inline Create Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center gap-2">
            <span class="material-symbols-outlined text-slate-400">add_circle</span>
            <h3 class="font-bold text-slate-800">Tambah Kemasan Baru</h3>
        </div>
        <form method="POST" action="{{ route('admin.kemasan.store') }}" class="p-6">
            @csrf
            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-sm text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">
                        Nama Kemasan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Botol Pump 100ml"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('name') border-red-400 @enderror"
                        required
                    >
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">
                        Jenis Kemasan <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="type"
                        name="type"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('type') border-red-400 @enderror"
                        required
                    >
                        <option value="">-- Pilih Jenis --</option>
                        <option value="botol"   {{ old('type') === 'botol'   ? 'selected' : '' }}>Botol</option>
                        <option value="tube"    {{ old('type') === 'tube'    ? 'selected' : '' }}>Tube</option>
                        <option value="sachet"  {{ old('type') === 'sachet'  ? 'selected' : '' }}>Sachet</option>
                        <option value="jar"     {{ old('type') === 'jar'     ? 'selected' : '' }}>Jar</option>
                        <option value="lainnya" {{ old('type') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Price per Unit -->
                <div>
                    <label for="price" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">
                        Harga / Pcs (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="0"
                            min="0"
                            step="100"
                            class="w-full pl-9 pr-3 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('price') border-red-400 @enderror"
                            required
                        >
                    </div>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-base">add</span>
                    Tambah Kemasan
                </button>
                <button type="reset" class="px-5 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </button>
            </div>
        </form>
    </div>

    <!-- Packaging Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Daftar Kemasan</h3>
            <span class="text-xs text-slate-400 font-medium">{{ method_exists($packagings, 'total') ? $packagings->total() : count($packagings) }} kemasan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Kemasan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga / Pcs</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ditambahkan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($packagings as $packaging)
                    @php
                        $typeColors = [
                            'botol'   => 'bg-blue-50 text-blue-700',
                            'tube'    => 'bg-violet-50 text-violet-700',
                            'sachet'  => 'bg-amber-50 text-amber-700',
                            'jar'     => 'bg-teal-50 text-teal-700',
                            'lainnya' => 'bg-slate-100 text-slate-600',
                        ];
                        $typeColor = $typeColors[$packaging->type] ?? 'bg-slate-100 text-slate-600';
                        $typeLabel = [
                            'botol'   => 'Botol',
                            'tube'    => 'Tube',
                            'sachet'  => 'Sachet',
                            'jar'     => 'Jar',
                            'lainnya' => 'Lainnya',
                        ][$packaging->type] ?? ucfirst($packaging->type);
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-800">{{ $packaging->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $typeColor }}">
                                {{ $typeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-800">
                                Rp {{ number_format($packaging->price, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-slate-400">/ pcs</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $packaging->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            <button type="button"
                                onclick="openEditKemasan({{ $packaging->id }}, '{{ addslashes($packaging->name) }}', '{{ $packaging->type }}', {{ $packaging->price }})"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary border border-primary/30 rounded-lg hover:bg-primary hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">edit</span>
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.kemasan.destroy', $packaging) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Hapus kemasan \"{{ addslashes($packaging->name) }}\"?')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">inventory</span>
                            <p class="text-slate-400 text-sm">Belum ada kemasan. Tambahkan melalui form di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($packagings, 'hasPages') && $packagings->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $packagings->links() }}</div>
        @endif
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-slate-800 text-lg">Edit Kemasan</h3>
            <button onclick="closeEditKemasan()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">Nama Kemasan *</label>
                <input type="text" name="name" id="editName" required
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">Jenis Kemasan *</label>
                <select name="type" id="editType" required
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    <option value="botol">Botol</option>
                    <option value="tube">Tube</option>
                    <option value="sachet">Sachet</option>
                    <option value="jar">Jar</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">Harga / Pcs (Rp) *</label>
                <input type="number" name="price" id="editPrice" min="0" step="100" required
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-primary text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditKemasan()"
                    class="flex-1 border border-slate-200 text-slate-600 py-2.5 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditKemasan(id, name, type, price) {
    document.getElementById('editName').value = name;
    document.getElementById('editType').value = type;
    document.getElementById('editPrice').value = price;
    document.getElementById('editForm').action = '/admin/kemasan/' + id;
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}
function closeEditKemasan() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditKemasan();
});
</script>
@endpush
