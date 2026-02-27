@extends('layouts.admin')
@section('title', 'Kelola Material')
@section('breadcrumb')<span class="text-primary font-medium">Kelola Material</span>@endsection

@section('content')
<div class="p-8 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Kelola Material</h2>
        <p class="text-slate-500 text-sm">Manajemen bahan baku dan material produksi</p>
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
            <h3 class="font-bold text-slate-800">Tambah Material Baru</h3>
        </div>
        <form method="POST" action="{{ route('admin.material.store') }}" class="p-6">
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
                        Nama Material <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Aqua Destilata"
                        list="existing-categories-name"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('name') border-red-400 @enderror"
                        required
                    >
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="category"
                        name="category"
                        value="{{ old('category') }}"
                        placeholder="Contoh: Emollient"
                        list="existing-categories"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('category') border-red-400 @enderror"
                        required
                    >
                    <datalist id="existing-categories">
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Price per ml -->
                <div>
                    <label for="price_per_ml" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">
                        Harga / ml (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                        <input
                            type="number"
                            id="price_per_ml"
                            name="price_per_ml"
                            value="{{ old('price_per_ml') }}"
                            placeholder="0"
                            min="0"
                            step="0.01"
                            class="w-full pl-9 pr-3 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors @error('price_per_ml') border-red-400 @enderror"
                            required
                        >
                    </div>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-base">add</span>
                    Tambah Material
                </button>
                <button type="reset" class="px-5 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </button>
            </div>
        </form>
    </div>

    <!-- Material Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Daftar Material</h3>
            <span class="text-xs text-slate-400 font-medium">{{ method_exists($materials, 'total') ? $materials->total() : count($materials) }} material</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Material</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga / ml</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ditambahkan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($materials as $material)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-800">{{ $material->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                {{ $material->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-800">
                                Rp {{ number_format($material->price_per_ml, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-slate-400">/ ml</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $material->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            <button type="button"
                                onclick="openEditMaterial({{ $material->id }}, '{{ addslashes($material->name) }}', '{{ addslashes($material->category) }}', {{ $material->price_per_ml }})"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary border border-primary/30 rounded-lg hover:bg-primary hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">edit</span>
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.material.destroy', $material) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Hapus material \"{{ addslashes($material->name) }}\"?')"
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
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">science</span>
                            <p class="text-slate-400 text-sm">Belum ada material. Tambahkan melalui form di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($materials, 'hasPages') && $materials->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $materials->links() }}</div>
        @endif
    </div>
</div>

<!-- Edit Modal -->
<div id="editMaterialModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-slate-800 text-lg">Edit Material</h3>
            <button onclick="closeEditMaterial()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editMaterialForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">Nama Material *</label>
                <input type="text" name="name" id="editMatName" required
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">Kategori *</label>
                <input type="text" name="category" id="editMatCategory" required list="cat-list"
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <datalist id="cat-list">
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}">
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wide">Harga / ml (Rp) *</label>
                <input type="number" name="price_per_ml" id="editMatPrice" min="0" step="0.01" required
                    class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-primary text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditMaterial()"
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
function openEditMaterial(id, name, category, price) {
    document.getElementById('editMatName').value = name;
    document.getElementById('editMatCategory').value = category;
    document.getElementById('editMatPrice').value = price;
    document.getElementById('editMaterialForm').action = '/admin/material/' + id;
    document.getElementById('editMaterialModal').classList.remove('hidden');
    document.getElementById('editMaterialModal').classList.add('flex');
}
function closeEditMaterial() {
    document.getElementById('editMaterialModal').classList.add('hidden');
    document.getElementById('editMaterialModal').classList.remove('flex');
}
document.getElementById('editMaterialModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditMaterial();
});
</script>
@endpush
