@extends('layouts.sidebar')

@section('title', 'MOU Order #' . $order->order_number)

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary transition-colors mb-3">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Order
        </a>
        <h1 class="text-2xl font-bold text-primary">MOU — Order #{{ $order->order_number }}</h1>
        <p class="text-slate-500 text-sm mt-1">Memorandum of Understanding kerjasama produksi</p>
    </div>

    <!-- Flash -->
    @if (session('success'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if (session('error'))
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
        <span class="material-symbols-outlined text-red-600">error</span>
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <!-- MOU Status Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-900">Status MOU</h2>
            @php
                $statusMap = [
                    'draft'    => ['label' => 'Draft', 'class' => 'bg-gray-100 text-gray-600'],
                    'waiting'  => ['label' => 'Menunggu TTD', 'class' => 'bg-yellow-100 text-yellow-700'],
                    'signed'   => ['label' => 'Sudah Ditandatangani', 'class' => 'bg-blue-100 text-blue-700'],
                    'approved' => ['label' => 'Disetujui Admin', 'class' => 'bg-green-100 text-green-700'],
                ];
                $s = $statusMap[$order->mou_status] ?? ['label' => $order->mou_status, 'class' => 'bg-gray-100 text-gray-600'];
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $s['class'] }}">{{ $s['label'] }}</span>
        </div>

        <!-- Steps -->
        <div class="flex items-center gap-2 text-xs">
            @foreach(['draft' => 'MOU Dibuat', 'waiting' => 'Menunggu TTD', 'signed' => 'TTD Diupload', 'approved' => 'Disetujui'] as $key => $label)
            @php $active = in_array($order->mou_status, match($key) {
                'draft'    => ['draft','waiting','signed','approved'],
                'waiting'  => ['waiting','signed','approved'],
                'signed'   => ['signed','approved'],
                'approved' => ['approved'],
                default    => [],
            }); @endphp
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold {{ $active ? 'bg-primary text-white' : 'bg-slate-100 text-slate-400' }}">
                    {{ array_search($key, array_keys(['draft'=>'','waiting'=>'','signed'=>'','approved'=>''])) + 1 }}
                </div>
                <span class="{{ $active ? 'text-primary font-semibold' : 'text-slate-400' }}">{{ $label }}</span>
            </div>
            @if(!$loop->last) <div class="flex-1 h-px bg-slate-200 min-w-[16px]"></div> @endif
            @endforeach
        </div>
    </div>

    <!-- MOU Content Preview -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">description</span>
            Dokumen MOU
        </h2>

        @if($mou && $mou->generated_pdf)
        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
            <span class="material-symbols-outlined text-red-500 text-3xl">picture_as_pdf</span>
            <div class="flex-1">
                <p class="font-medium text-gray-900 text-sm">MOU_{{ $order->order_number }}.pdf</p>
                <p class="text-xs text-slate-500">Dokumen MOU yang dihasilkan sistem</p>
            </div>
            <a href="{{ route('mou.download', $order) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined text-base">download</span>
                Download
            </a>
        </div>
        @else
        <div class="text-center py-10 text-slate-400">
            <span class="material-symbols-outlined text-5xl mb-2">description</span>
            <p class="text-sm">Dokumen MOU belum tersedia.</p>
            <p class="text-xs mt-1">Admin akan menggenerate dokumen MOU segera.</p>
        </div>
        @endif
    </div>

    <!-- Upload Signed MOU -->
    @if(in_array($order->mou_status, ['waiting', 'draft']))
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">upload_file</span>
            Upload MOU yang Sudah Ditandatangani
        </h2>
        <p class="text-sm text-slate-500 mb-5">Download dokumen MOU di atas, tanda tangani, lalu upload kembali di sini.</p>

        <form action="{{ route('mou.upload', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
            @endif
            <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-primary transition-colors cursor-pointer" id="dropZone">
                <span class="material-symbols-outlined text-slate-400 text-4xl mb-2">cloud_upload</span>
                <p class="text-sm font-medium text-slate-600">Klik atau drag file ke sini</p>
                <p class="text-xs text-slate-400 mt-1">PDF, JPG, PNG — maks. 10MB</p>
                <input type="file" name="signed_mou" id="signed_mou" accept=".pdf,.jpg,.jpeg,.png"
                       class="hidden" required>
                <p id="fileName" class="text-xs text-primary font-medium mt-2 hidden"></p>
            </div>
            <button type="submit"
                    class="mt-4 w-full bg-primary text-white py-3 rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                Upload MOU Bertandatangan
            </button>
        </form>
    </div>
    @elseif($order->mou_status === 'signed')
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex items-start gap-3">
        <span class="material-symbols-outlined text-blue-600 mt-0.5">info</span>
        <div>
            <p class="text-sm font-semibold text-blue-800">MOU sudah diupload</p>
            <p class="text-sm text-blue-600 mt-0.5">Menunggu verifikasi dari admin. Proses biasanya 1-2 hari kerja.</p>
        </div>
    </div>
    @elseif($order->mou_status === 'approved')
    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex items-start gap-3">
        <span class="material-symbols-outlined text-green-600 mt-0.5">check_circle</span>
        <div>
            <p class="text-sm font-semibold text-green-800">MOU telah disetujui!</p>
            <p class="text-sm text-green-600 mt-0.5">Kerjasama Anda telah resmi. Proses produksi akan segera dimulai.</p>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const dropZone = document.getElementById('dropZone');
    const input = document.getElementById('signed_mou');
    const fileName = document.getElementById('fileName');
    if(dropZone) {
        dropZone.addEventListener('click', () => input.click());
        input.addEventListener('change', () => {
            if(input.files[0]) {
                fileName.textContent = '✓ ' + input.files[0].name;
                fileName.classList.remove('hidden');
            }
        });
        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-primary','bg-primary/5'); });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-primary','bg-primary/5'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-primary','bg-primary/5');
            if(e.dataTransfer.files[0]) {
                const dt = new DataTransfer();
                dt.items.add(e.dataTransfer.files[0]);
                input.files = dt.files;
                fileName.textContent = '✓ ' + e.dataTransfer.files[0].name;
                fileName.classList.remove('hidden');
            }
        });
    }
</script>
@endpush
