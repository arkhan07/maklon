@extends('layouts.sidebar')
@section('title', 'Upload Bukti Pembayaran')
@section('breadcrumb')
    <a href="{{ route('invoices.index') }}" class="hover:text-primary transition-colors">Invoice</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">Bayar</span>
@endsection

@section('content')
<div class="p-8 max-w-2xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Upload Bukti Pembayaran</h2>
        <p class="text-slate-500 text-sm">Invoice #{{ $invoice->invoice_number }} — {{ $invoice->formattedAmount() }}</p>
    </div>

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-lg space-y-1">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-600 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">error</span>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <!-- Info Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Informasi Pembayaran</h3>
        <div class="bg-primary/5 border border-primary/10 rounded-lg p-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Bank</span>
                <span class="font-semibold text-slate-800">BCA - 1234567890</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Atas Nama</span>
                <span class="font-semibold text-slate-800">PT Maklon Indonesia</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Total Transfer</span>
                <span class="font-bold text-primary text-base">{{ $invoice->formattedAmount() }}</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('payments.store', $invoice) }}" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Jumlah yang Ditransfer <span class="text-red-500">*</span></label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-medium text-sm">Rp</span>
                <input type="number" name="amount" value="{{ old('amount', $invoice->amount) }}" required min="1"
                    class="block w-full pl-12 pr-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all"/>
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Metode Pembayaran <span class="text-red-500">*</span></label>
            <select name="method" required class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all bg-white">
                <option value="transfer" {{ old('method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                <option value="qris" {{ old('method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                <option value="virtual_account" {{ old('method') == 'virtual_account' ? 'selected' : '' }}>Virtual Account</option>
            </select>
        </div>

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Bukti Transfer <span class="text-red-500">*</span></label>
            <div class="border-2 border-dashed border-slate-200 rounded-lg p-6 text-center hover:border-primary/30 transition-colors cursor-pointer" id="dropzone">
                <span class="material-symbols-outlined text-3xl text-slate-300 mb-2 block">upload_file</span>
                <p class="text-sm text-slate-500">Klik atau seret file ke sini</p>
                <p class="text-xs text-slate-400 mt-1">JPG, PNG, atau PDF • Maks 2MB</p>
                <input type="file" name="proof" id="proof" accept=".jpg,.jpeg,.png,.pdf" required class="hidden"/>
                <p class="text-xs text-primary font-medium mt-3" id="fileName">Belum ada file dipilih</p>
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="text-sm font-semibold text-slate-700">Catatan (opsional)</label>
            <textarea name="notes" rows="3" placeholder="Nomor referensi, waktu transfer, dll..."
                class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary transition-all resize-none placeholder:text-slate-400">{{ old('notes') }}</textarea>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-bold hover:bg-primary/90 transition-all shadow-md">
                Kirim Bukti
            </button>
            <a href="{{ route('invoices.show', $invoice) }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const dropzone = document.getElementById('dropzone');
    const input = document.getElementById('proof');
    const fileName = document.getElementById('fileName');
    dropzone.addEventListener('click', () => input.click());
    input.addEventListener('change', () => {
        fileName.textContent = input.files[0] ? input.files[0].name : 'Belum ada file dipilih';
    });
    dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('border-primary'); });
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-primary'));
    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-primary');
        input.files = e.dataTransfer.files;
        fileName.textContent = input.files[0]?.name ?? 'Belum ada file';
    });
</script>
@endpush
