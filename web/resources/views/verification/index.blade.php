@extends('layouts.sidebar')

@section('title', 'Verifikasi Legalitas')

@section('breadcrumb')
    <span class="text-primary font-medium">Verifikasi Legalitas</span>
@endsection

@section('content')
<div class="p-8 max-w-4xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="text-center">
        <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
            <span class="material-symbols-outlined text-sm">shield</span>
            Verifikasi Akun
        </div>
        <h1 class="text-3xl font-extrabold text-primary mb-2">Verifikasi Legalitas Bisnis Anda</h1>
        <p class="text-slate-500">Sebelum dapat melakukan order, akun Anda perlu diverifikasi.</p>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('warning'))
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3">
        <span class="material-symbols-outlined text-amber-600">warning</span>
        <p class="text-amber-700 font-medium">{{ session('warning') }}</p>
    </div>
    @endif

    {{-- Status Banner --}}
    @if($user->verification_status === 'pending')
    <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-6 flex items-start gap-4">
        <div class="p-3 bg-amber-100 rounded-xl">
            <span class="material-symbols-outlined text-amber-600 text-3xl">hourglass_empty</span>
        </div>
        <div>
            <h3 class="font-bold text-amber-800 text-lg">Dokumen Sedang Diverifikasi</h3>
            <p class="text-amber-700 text-sm mt-1">Tim kami sedang meninjau dokumen Anda. Proses ini memerlukan 1–3 hari kerja. Kami akan menghubungi Anda via WhatsApp/Email.</p>
        </div>
    </div>
    @elseif($user->verification_status === 'rejected')
    <div class="bg-red-50 border-2 border-red-300 rounded-2xl p-6 flex items-start gap-4">
        <div class="p-3 bg-red-100 rounded-xl">
            <span class="material-symbols-outlined text-red-600 text-3xl">cancel</span>
        </div>
        <div>
            <h3 class="font-bold text-red-800 text-lg">Verifikasi Ditolak</h3>
            <p class="text-red-700 text-sm mt-1">{{ $user->verification_notes ?? 'Dokumen tidak memenuhi syarat. Silakan upload ulang.' }}</p>
            <p class="text-red-600 text-sm font-semibold mt-2">Silakan upload dokumen yang benar di bawah ini.</p>
        </div>
    </div>
    @endif

    {{-- Two Options --}}
    @if(!in_array($user->verification_status, ['verified', 'pending']))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Option A: Upload Documents --}}
        <div class="bg-white rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2.5 bg-blue-100 rounded-xl">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">folder_open</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Opsi A: Upload Dokumen</h3>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">GRATIS</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm mb-4">Sudah punya PT/CV? Upload dokumen legalitas untuk diverifikasi.</p>
            <div class="bg-slate-50 rounded-xl p-3 mb-4 text-xs text-slate-600 space-y-1">
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-slate-400">check</span> Akta Pendirian Perusahaan</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-slate-400">check</span> NIB (Nomor Induk Berusaha)</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-slate-400">check</span> SIUP / Izin Usaha</div>
                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-slate-400">check</span> KTP Direktur</div>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-2.5 mb-4 text-xs text-amber-700">
                <strong>⚠️ Fitur terkunci</strong> hingga admin approve (1–3 hari kerja)
            </div>

            <form action="{{ route('verification.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div id="docInputs" class="space-y-3">
                    <div class="flex gap-2">
                        <select name="doc_types[]" class="w-1/3 text-xs border border-slate-200 rounded-lg px-2 py-2 focus:ring-primary focus:border-primary">
                            <option value="akta">Akta</option>
                            <option value="nib">NIB</option>
                            <option value="siup">SIUP</option>
                            <option value="ktp">KTP</option>
                            <option value="npwp">NPWP</option>
                        </select>
                        <input type="file" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" required class="flex-1 text-xs border border-slate-200 rounded-lg px-2 py-2 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-primary file:text-white cursor-pointer">
                    </div>
                </div>
                <button type="button" onclick="addDocInput()" class="mt-2 text-xs text-blue-600 font-semibold hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">add</span> Tambah dokumen
                </button>
                <button type="submit" class="mt-4 w-full bg-primary hover:bg-primary/90 text-white py-2.5 rounded-xl font-semibold text-sm transition-all">
                    Upload Dokumen
                </button>
            </form>
        </div>

        {{-- Option B: Buy Package --}}
        <div class="bg-white rounded-2xl border-2 border-violet-200 hover:border-violet-400 transition-all p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2.5 bg-violet-100 rounded-xl">
                    <span class="material-symbols-outlined text-violet-600 text-2xl">gavel</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Opsi B: Beli Paket Legalitas</h3>
                    <span class="text-xs font-bold text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full">LANGSUNG AKTIF</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm mb-4">Belum punya PT/CV? Beli paket pendirian PT lengkap beserta izin usaha.</p>
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-2.5 mb-4 text-xs text-emerald-700">
                <strong>✅ Akun langsung aktif</strong> setelah pembayaran dikonfirmasi
            </div>

            <form action="{{ route('verification.buy_package') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <label class="flex items-start gap-3 p-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-violet-300 has-[:checked]:border-violet-500 has-[:checked]:bg-violet-50 transition-all">
                        <input type="radio" name="package_type" value="pt_perorangan" class="mt-0.5 accent-violet-600" required>
                        <div>
                            <div class="font-bold text-slate-800 text-sm">PT Perorangan</div>
                            <div class="text-slate-500 text-xs">Cocok untuk usaha skala kecil-menengah</div>
                            <div class="text-violet-600 font-bold text-sm mt-1">Rp 1.500.000</div>
                        </div>
                    </label>
                    <label class="flex items-start gap-3 p-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-violet-300 has-[:checked]:border-violet-500 has-[:checked]:bg-violet-50 transition-all">
                        <input type="radio" name="package_type" value="pt_perseroan" class="mt-0.5 accent-violet-600">
                        <div>
                            <div class="font-bold text-slate-800 text-sm">PT Perseroan Terbatas</div>
                            <div class="text-slate-500 text-xs">Untuk usaha skala besar dengan banyak pemegang saham</div>
                            <div class="text-violet-600 font-bold text-sm mt-1">Rp 5.000.000</div>
                        </div>
                    </label>
                </div>
                <p class="text-xs text-slate-400 mt-3">* Setelah memilih, Anda akan dihubungi tim kami untuk proses pembayaran dan pengurusan dokumen (7–14 hari kerja)</p>
                <button type="submit" class="mt-4 w-full bg-violet-600 hover:bg-violet-700 text-white py-2.5 rounded-xl font-semibold text-sm transition-all">
                    Pilih Paket Legalitas
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- Uploaded Documents --}}
    @if($documents->count() > 0)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900">Dokumen yang Diupload</h3>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach($documents as $doc)
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">description</span>
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $doc->getTypeLabel() }}</p>
                        <p class="text-xs text-slate-400">{{ $doc->original_name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($doc->status === 'approved')
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full">✅ Approved</span>
                    @elseif($doc->status === 'rejected')
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">❌ Ditolak</span>
                    @else
                        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">⏳ Pending</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
function addDocInput() {
    const container = document.getElementById('docInputs');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <select name="doc_types[]" class="w-1/3 text-xs border border-slate-200 rounded-lg px-2 py-2">
            <option value="akta">Akta</option>
            <option value="nib">NIB</option>
            <option value="siup">SIUP</option>
            <option value="ktp">KTP</option>
            <option value="npwp">NPWP</option>
        </select>
        <input type="file" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" required class="flex-1 text-xs border border-slate-200 rounded-lg px-2 py-2 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-primary file:text-white cursor-pointer">
    `;
    container.appendChild(div);
}
</script>
@endpush
@endsection
