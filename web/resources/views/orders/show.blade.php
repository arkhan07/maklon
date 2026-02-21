@extends('layouts.sidebar')
@section('title', $order->status === 'draft' ? 'Buat Order - Langkah ' . $currentStep : 'Detail Order #' . $order->order_number)
@section('breadcrumb')
    <a href="{{ route('orders.index') }}" class="hover:text-primary transition-colors">Order Saya</a>
    <span class="text-slate-300">/</span>
    <span class="text-primary font-medium">#{{ $order->order_number }}</span>
@endsection

@section('content')
<div class="p-6 lg:p-8">

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl space-y-1">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-600 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">error</span>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- ============================= WIZARD MODE (DRAFT) ============================= --}}
    @if($order->status === 'draft')

    {{-- Step Indicators --}}
    @php
        $steps = [
            1 => ['icon' => 'storefront', 'label' => 'Brand'],
            2 => ['icon' => 'science',    'label' => 'Produk'],
            3 => ['icon' => 'biotech',    'label' => 'Formula'],
            4 => ['icon' => 'inventory_2','label' => 'Kemasan'],
            5 => ['icon' => 'palette',    'label' => 'Desain'],
            6 => ['icon' => 'task_alt',   'label' => 'Review'],
        ];
    @endphp

    <div class="mb-8">
        <div class="flex items-center">
            @foreach($steps as $n => $s)
            @php $done = $n < $currentStep; $active = $n === $currentStep; @endphp
            <a href="{{ $n < $currentStep ? route('orders.show', [$order, 'step' => $n]) : '#' }}"
               class="flex flex-col items-center {{ $n < $currentStep ? 'cursor-pointer' : 'cursor-default' }} {{ $n < count($steps) ? 'flex-1' : '' }}">
                <div class="size-10 rounded-full flex items-center justify-center text-sm font-bold transition-all
                    {{ $done ? 'bg-emerald-500 text-white' : ($active ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-slate-100 text-slate-400') }}">
                    @if($done)
                        <span class="material-symbols-outlined text-base">check</span>
                    @else
                        <span class="material-symbols-outlined text-base">{{ $s['icon'] }}</span>
                    @endif
                </div>
                <p class="text-[10px] mt-1.5 font-semibold hidden sm:block
                    {{ $active ? 'text-primary' : ($done ? 'text-emerald-600' : 'text-slate-400') }}">
                    {{ $s['label'] }}
                </p>
            </a>
            @if($n < count($steps))
            <div class="flex-1 h-0.5 mx-1 mb-4 {{ $n < $currentStep ? 'bg-emerald-400' : 'bg-slate-200' }}"></div>
            @endif
            @endforeach
        </div>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="mb-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Langkah {{ $currentStep }} dari 6</p>
            <h2 class="text-xl font-bold text-slate-900 mt-0.5">
                @php echo [1=>'Brand & Legalitas', 2=>'Pilih Produk', 3=>'Formula / Bahan Aktif', 4=>'Kemasan & Kuantitas', 5=>'Desain & Sampel', 6=>'Review & Submit'][$currentStep]; @endphp
            </h2>
        </div>

        {{-- =================== STEP 1: BRAND & LEGALITAS =================== --}}
        @if($currentStep === 1)
        <form method="POST" action="{{ route('orders.step', $order) }}" class="space-y-6">
            @csrf @method('PUT')
            <input type="hidden" name="step" value="1">

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
                <div>
                    <p class="text-sm font-semibold text-slate-700 mb-3">Tipe Brand <span class="text-red-500">*</span></p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="brand_type" value="undername" class="peer sr-only"
                                {{ old('brand_type', $order->brand_type) === 'undername' ? 'checked' : '' }}>
                            <div class="border-2 rounded-xl p-5 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40">
                                <span class="material-symbols-outlined text-2xl text-slate-500 peer-checked:text-primary">corporate_fare</span>
                                <p class="font-bold text-slate-800 mt-2">Undername</p>
                                <p class="text-xs text-slate-500 mt-1">Produk dipasarkan dengan nama brand Maklon (lebih cepat & murah)</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="brand_type" value="haki" class="peer sr-only"
                                {{ old('brand_type', $order->brand_type) === 'haki' ? 'checked' : '' }}>
                            <div class="border-2 rounded-xl p-5 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40">
                                <span class="material-symbols-outlined text-2xl text-slate-500">verified</span>
                                <p class="font-bold text-slate-800 mt-2">HAKI / Brand Sendiri</p>
                                <p class="text-xs text-slate-500 mt-1">Produk dengan nama brand Anda sendiri yang terdaftar HAKI</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">Nama Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="brand_name" value="{{ old('brand_name', $order->brand_name) }}"
                        placeholder="contoh: GlowSkin, PureLab, NatureCare..."
                        class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary placeholder:text-slate-400">
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-semibold text-slate-700 mb-1">Layanan Legal Tambahan</p>
                <p class="text-xs text-slate-400 mb-4">Pilih sertifikasi yang ingin Anda daftarkan (biaya akan ditambahkan)</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @php
                        $legals = [
                            ['key' => 'include_bpom',  'label' => 'Pendaftaran BPOM',    'price' => 1250000, 'icon' => 'verified_user',  'desc' => 'Nomor notifikasi BPOM'],
                            ['key' => 'include_halal', 'label' => 'Sertifikasi Halal',   'price' => 2500000, 'icon' => 'mosque',          'desc' => 'Sertifikat Halal MUI'],
                            ['key' => 'include_logo',  'label' => 'Desain Logo',          'price' => 1500000, 'icon' => 'brush',           'desc' => 'Desain logo profesional'],
                            ['key' => 'include_haki',  'label' => 'Pendaftaran HAKI',     'price' => 2750000, 'icon' => 'gavel',           'desc' => 'Hak Kekayaan Intelektual'],
                        ];
                    @endphp
                    @foreach($legals as $l)
                    <label class="flex items-start gap-3 p-4 border border-slate-200 rounded-lg cursor-pointer hover:border-primary/40 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                        <input type="checkbox" name="{{ $l['key'] }}" value="1" class="mt-0.5 text-primary rounded"
                            {{ old($l['key'], $order->{$l['key']}) ? 'checked' : '' }}>
                        <span class="material-symbols-outlined text-slate-400 text-xl">{{ $l['icon'] }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800">{{ $l['label'] }}</p>
                            <p class="text-xs text-slate-400">{{ $l['desc'] }}</p>
                            <p class="text-xs font-bold text-primary mt-0.5">+ Rp {{ number_format($l['price'], 0, ',', '.') }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('orders.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium">Kembali ke Daftar</a>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                    Simpan & Lanjut <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </form>

        {{-- =================== STEP 2: PILIH PRODUK =================== --}}
        @elseif($currentStep === 2)
        <form method="POST" action="{{ route('orders.step', $order) }}" class="space-y-6" id="step2-form">
            @csrf @method('PUT')
            <input type="hidden" name="step" value="2">
            <input type="hidden" name="product_id" id="selected_product_id" value="{{ old('product_id', $order->product_id) }}">

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-5">
                {{-- Category cascade --}}
                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block">Kategori Produk</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <select id="cat_l1" class="px-4 py-3 border border-slate-200 rounded-lg text-slate-800 focus:ring-primary focus:border-primary bg-white">
                            <option value="">-- Kategori Utama --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <select id="cat_l2" class="px-4 py-3 border border-slate-200 rounded-lg text-slate-800 focus:ring-primary focus:border-primary bg-white" disabled>
                            <option value="">-- Sub Kategori --</option>
                        </select>
                        <select id="cat_l3" class="px-4 py-3 border border-slate-200 rounded-lg text-slate-800 focus:ring-primary focus:border-primary bg-white" disabled>
                            <option value="">-- Jenis Produk --</option>
                        </select>
                    </div>
                </div>

                {{-- Product list --}}
                <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 gap-3 min-h-[80px]">
                    <div class="col-span-2 text-center py-8 text-slate-400 text-sm" id="product-placeholder">
                        <span class="material-symbols-outlined text-3xl block mb-2">category</span>
                        Pilih kategori untuk melihat produk
                    </div>
                </div>

                {{-- Selected product info --}}
                <div id="product-selected-info" class="hidden p-4 bg-primary/5 border border-primary/20 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <div>
                        <p class="text-sm font-semibold text-slate-800" id="selected-product-name"></p>
                        <p class="text-xs text-slate-500" id="selected-product-price"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-2">
                <label class="text-sm font-semibold text-slate-700">Volume per Unit (ml) <span class="text-red-500">*</span></label>
                <p class="text-xs text-slate-400">Seberapa banyak isi produk dalam setiap unit kemasan</p>
                <div class="flex items-center gap-3">
                    <input type="number" name="volume_ml" value="{{ old('volume_ml', $order->volume_ml) }}" min="1" max="5000"
                        placeholder="contoh: 30"
                        class="w-48 px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary placeholder:text-slate-400">
                    <span class="text-slate-500 font-medium">ml / unit</span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('orders.show', [$order, 'step' => 1]) }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                    Simpan & Lanjut <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </form>

        <script>
        (function(){
            const catData = @json($categories);
            const l1 = document.getElementById('cat_l1');
            const l2 = document.getElementById('cat_l2');
            const l3 = document.getElementById('cat_l3');
            const productList = document.getElementById('product-list');
            const placeholder = document.getElementById('product-placeholder');
            const selectedInput = document.getElementById('selected_product_id');
            const selectedInfo = document.getElementById('product-selected-info');
            const selectedName = document.getElementById('selected-product-name');
            const selectedPrice = document.getElementById('selected-product-price');

            function fmt(n){ return 'Rp ' + parseInt(n).toLocaleString('id-ID'); }

            function loadProducts(categoryId){
                fetch(`/api/products?category_id=${categoryId}`)
                    .then(r=>r.json()).then(products=>{
                        placeholder && placeholder.remove();
                        productList.innerHTML = '';
                        if(!products.length){
                            productList.innerHTML = '<div class="col-span-2 text-center py-6 text-slate-400 text-sm">Tidak ada produk di kategori ini</div>';
                            return;
                        }
                        products.forEach(p=>{
                            const div = document.createElement('label');
                            div.className = 'cursor-pointer';
                            div.innerHTML = `
                                <input type="radio" name="_product_radio" value="${p.id}" class="sr-only peer"
                                    ${selectedInput.value == p.id ? 'checked' : ''}>
                                <div class="border-2 rounded-xl p-4 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40">
                                    <p class="font-semibold text-slate-800 text-sm">${p.name}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">${p.category ? p.category.name : ''}</p>
                                    <p class="text-xs font-bold text-primary mt-1">Base: ${fmt(p.base_price)} / 100 pcs</p>
                                </div>`;
                            div.querySelector('input').addEventListener('change', function(){
                                selectedInput.value = p.id;
                                selectedName.textContent = p.name;
                                selectedPrice.textContent = 'Harga dasar: ' + fmt(p.base_price) + ' / 100 pcs';
                                selectedInfo.classList.remove('hidden');
                            });
                            productList.appendChild(div);
                        });
                    });
            }

            function buildOptions(select, items, placeholder){
                select.innerHTML = `<option value="">${placeholder}</option>`;
                items.forEach(i => {
                    const o = document.createElement('option'); o.value=i.id; o.textContent=i.name;
                    select.appendChild(o);
                });
                select.disabled = !items.length;
            }

            l1.addEventListener('change', function(){
                const cat = catData.find(c=>c.id==this.value);
                const children = cat ? (cat.children||[]) : [];
                buildOptions(l2, children, '-- Sub Kategori --');
                buildOptions(l3, [], '-- Jenis Produk --');
                if(children.length) { l2.disabled=false; } else { loadProducts(this.value); }
            });
            l2.addEventListener('change', function(){
                const l1Cat = catData.find(c=>c.id==l1.value);
                const l2Cat = (l1Cat?.children||[]).find(c=>c.id==this.value);
                const children = l2Cat ? (l2Cat.children||[]) : [];
                buildOptions(l3, children, '-- Jenis Produk --');
                if(children.length) { l3.disabled=false; } else { loadProducts(this.value); }
            });
            l3.addEventListener('change', function(){
                if(this.value) loadProducts(this.value);
            });

            // Pre-select if product already chosen
            @if($order->product_id)
            const selProd = {{ $order->product ? json_encode(['id'=>$order->product->id,'name'=>$order->product->name,'base_price'=>$order->product->base_price]) : 'null' }};
            if(selProd){
                selectedName.textContent = selProd.name;
                selectedPrice.textContent = 'Harga dasar: ' + fmt(selProd.base_price) + ' / 100 pcs';
                selectedInfo.classList.remove('hidden');
            }
            @endif
        })();
        </script>

        {{-- =================== STEP 3: FORMULA / BAHAN =================== --}}
        @elseif($currentStep === 3)
        @php
            $selectedMats = collect($order->selected_materials ?? []);
            $matGroups = $materials->groupBy('category');
        @endphp
        <form method="POST" action="{{ route('orders.step', $order) }}" class="space-y-6">
            @csrf @method('PUT')
            <input type="hidden" name="step" value="3">

            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                <span class="material-symbols-outlined text-blue-500 flex-shrink-0">info</span>
                <p class="text-sm text-blue-700">Pilih bahan aktif yang ingin Anda tambahkan ke formula produk. Tim formulator kami akan menyesuaikan konsentrasi sesuai standar keamanan.</p>
            </div>

            @foreach($matGroups as $category => $matList)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                    <p class="font-bold text-slate-700 text-sm uppercase tracking-wider">{{ $category }}</p>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($matList as $mat)
                    @php
                        $selMat = $selectedMats->firstWhere('material_id', $mat->id);
                        $checked = !is_null($selMat);
                        $dose = $selMat['dose_ml'] ?? '';
                    @endphp
                    <div class="px-6 py-4 flex items-center gap-4" x-data="{on: {{ $checked ? 'true' : 'false' }}}">
                        <input type="checkbox" name="selected_materials_check[]" value="{{ $mat->id }}"
                            class="material-check rounded text-primary" data-id="{{ $mat->id }}" {{ $checked ? 'checked' : '' }}>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800">{{ $mat->name }}</p>
                            <p class="text-xs text-slate-400">{{ 'Rp ' . number_format($mat->price_per_ml, 0, ',', '.') }} / ml</p>
                        </div>
                        <div class="flex items-center gap-2 material-dose-wrap {{ $checked ? '' : 'hidden' }}" data-for="{{ $mat->id }}">
                            <input type="number" name="mat_dose_{{ $mat->id }}" value="{{ $dose }}"
                                step="0.1" min="0.1" max="50" placeholder="ml"
                                class="w-24 px-3 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 focus:ring-primary focus:border-primary placeholder:text-slate-400">
                            <span class="text-xs text-slate-500 whitespace-nowrap">ml / unit</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            {{-- Hidden inputs for selected_materials array --}}
            <div id="materials-hidden"></div>

            <div class="flex items-center justify-between">
                <a href="{{ route('orders.show', [$order, 'step' => 2]) }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                    Simpan & Lanjut <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </form>
        <script>
        (function(){
            const checks = document.querySelectorAll('.material-check');
            const hiddenContainer = document.getElementById('materials-hidden');

            function rebuild(){
                hiddenContainer.innerHTML = '';
                let idx = 0;
                checks.forEach(cb => {
                    if(cb.checked){
                        const id = cb.value;
                        const doseInput = document.querySelector(`input[name="mat_dose_${id}"]`);
                        const dose = doseInput ? doseInput.value : 0;
                        const iId = document.createElement('input');
                        iId.type='hidden'; iId.name=`selected_materials[${idx}][material_id]`; iId.value=id;
                        const iDose = document.createElement('input');
                        iDose.type='hidden'; iDose.name=`selected_materials[${idx}][dose_ml]`; iDose.value=dose;
                        hiddenContainer.appendChild(iId);
                        hiddenContainer.appendChild(iDose);
                        idx++;
                    }
                });
            }

            checks.forEach(cb => {
                cb.addEventListener('change', function(){
                    const wrap = document.querySelector(`.material-dose-wrap[data-for="${this.value}"]`);
                    if(wrap) wrap.classList.toggle('hidden', !this.checked);
                    rebuild();
                });
            });

            document.querySelectorAll('input[name^="mat_dose_"]').forEach(inp => {
                inp.addEventListener('input', rebuild);
            });

            rebuild(); // init
        })();
        </script>

        {{-- =================== STEP 4: KEMASAN & KUANTITAS =================== --}}
        @elseif($currentStep === 4)
        <form method="POST" action="{{ route('orders.step', $order) }}" class="space-y-6">
            @csrf @method('PUT')
            <input type="hidden" name="step" value="4">

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <p class="text-sm font-semibold text-slate-700">Pilih Jenis Kemasan <span class="text-red-500">*</span></p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($packagingTypes as $pkg)
                    <label class="cursor-pointer">
                        <input type="radio" name="packaging_type_id" value="{{ $pkg->id }}" class="sr-only peer"
                            {{ old('packaging_type_id', $order->packaging_type_id) == $pkg->id ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-5 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40 h-full">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                <span class="material-symbols-outlined text-slate-500 text-xl">inventory_2</span>
                            </div>
                            <p class="font-bold text-slate-800 text-sm">{{ $pkg->name }}</p>
                            @if($pkg->description)<p class="text-xs text-slate-400 mt-1">{{ $pkg->description }}</p>@endif
                            <p class="text-sm font-bold text-primary mt-2">Rp {{ number_format($pkg->price, 0, ',', '.') }} / pcs</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">Jumlah Produksi (Pcs) <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-400">Minimum order 100 pcs. Semakin banyak, semakin hemat.</p>
                    <div class="flex items-center gap-3">
                        <input type="number" name="quantity" value="{{ old('quantity', $order->quantity) }}" min="100" step="50"
                            placeholder="contoh: 500"
                            class="w-48 px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary placeholder:text-slate-400">
                        <span class="text-slate-500 font-medium">pcs</span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach([100, 250, 500, 1000, 2000, 5000] as $qty)
                    <button type="button" onclick="document.querySelector('[name=quantity]').value='{{ $qty }}'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 hover:border-primary hover:text-primary transition-all">
                        {{ number_format($qty) }} pcs
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('orders.show', [$order, 'step' => 3]) }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                    Simpan & Lanjut <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </form>

        {{-- =================== STEP 5: DESAIN & SAMPEL =================== --}}
        @elseif($currentStep === 5)
        <form method="POST" action="{{ route('orders.step', $order) }}" class="space-y-6">
            @csrf @method('PUT')
            <input type="hidden" name="step" value="5">

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <p class="text-sm font-semibold text-slate-700">Opsi Desain Label / Kemasan <span class="text-red-500">*</span></p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="design_option" value="service" class="sr-only peer"
                            {{ old('design_option', $order->design_option) === 'service' ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-5 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40 h-full text-center">
                            <span class="material-symbols-outlined text-3xl text-slate-400">draw</span>
                            <p class="font-bold text-slate-800 mt-2 text-sm">Jasa Desain</p>
                            <p class="text-xs text-slate-400 mt-1">Tim desainer kami membuatkan desain sesuai konsep Anda</p>
                            <p class="text-xs font-bold text-primary mt-2">+ Rp 750.000</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="design_option" value="self_upload" class="sr-only peer"
                            {{ old('design_option', $order->design_option) === 'self_upload' ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-5 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40 h-full text-center">
                            <span class="material-symbols-outlined text-3xl text-slate-400">upload_file</span>
                            <p class="font-bold text-slate-800 mt-2 text-sm">Upload Desain Sendiri</p>
                            <p class="text-xs text-slate-400 mt-1">Anda sudah memiliki file desain (AI, CDR, PDF)</p>
                            <p class="text-xs font-bold text-emerald-600 mt-2">Gratis</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="design_option" value="none" class="sr-only peer"
                            {{ old('design_option', $order->design_option) === 'none' ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-5 transition-all peer-checked:border-primary peer-checked:bg-primary/5 border-slate-200 hover:border-primary/40 h-full text-center">
                            <span class="material-symbols-outlined text-3xl text-slate-400">block</span>
                            <p class="font-bold text-slate-800 mt-2 text-sm">Tanpa Desain</p>
                            <p class="text-xs text-slate-400 mt-1">Produk tanpa label (unlabeled / polos)</p>
                            <p class="text-xs font-bold text-emerald-600 mt-2">Gratis</p>
                        </div>
                    </label>
                </div>

                <div id="design-url-section" class="{{ old('design_option', $order->design_option) === 'self_upload' ? '' : 'hidden' }} space-y-3">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-slate-700">Link File Desain (Google Drive / Dropbox)</label>
                        <input type="url" name="design_file_url" value="{{ old('design_file_url', $order->design_file_url) }}"
                            placeholder="https://drive.google.com/..."
                            class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary placeholder:text-slate-400">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700">Deskripsi / Catatan Desain</label>
                    <textarea name="design_description" rows="3"
                        placeholder="Jelaskan konsep desain, warna, gaya, atau referensi yang Anda inginkan..."
                        class="block w-full px-4 py-3 border border-slate-200 rounded-lg text-slate-900 focus:ring-primary focus:border-primary placeholder:text-slate-400 resize-none">{{ old('design_description', $order->design_description) }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <label class="flex items-start gap-4 cursor-pointer">
                    <input type="checkbox" name="request_sample" value="1" class="mt-1 text-primary rounded"
                        {{ old('request_sample', $order->request_sample) ? 'checked' : '' }}>
                    <div>
                        <p class="font-semibold text-slate-800">Minta Sampel Produksi</p>
                        <p class="text-xs text-slate-400 mt-0.5">Kami akan mengirimkan 1 unit sampel sebelum produksi massal dimulai</p>
                        <p class="text-sm font-bold text-primary mt-1">+ Rp 500.000</p>
                    </div>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('orders.show', [$order, 'step' => 4]) }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                </a>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md flex items-center gap-2">
                    Lanjut ke Review <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </div>
        </form>
        <script>
        document.querySelectorAll('[name="design_option"]').forEach(r=>{
            r.addEventListener('change', function(){
                document.getElementById('design-url-section').classList.toggle('hidden', this.value !== 'self_upload');
            });
        });
        </script>

        {{-- =================== STEP 6: REVIEW & SUBMIT =================== --}}
        @elseif($currentStep === 6)
        @php
            $rp = fn($v) => 'Rp ' . number_format((float)$v, 0, ',', '.');
        @endphp

        <div class="space-y-6">
            {{-- Brand Summary --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-lg">storefront</span>Brand & Legalitas</h3>
                    <a href="{{ route('orders.show', [$order, 'step' => 1]) }}" class="text-xs text-primary font-semibold hover:underline">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><p class="text-xs text-slate-400">Tipe Brand</p><p class="font-semibold text-slate-800">{{ $order->brand_type === 'haki' ? 'HAKI / Brand Sendiri' : 'Undername' }}</p></div>
                    <div><p class="text-xs text-slate-400">Nama Brand</p><p class="font-semibold text-slate-800">{{ $order->brand_name }}</p></div>
                    <div class="col-span-2"><p class="text-xs text-slate-400 mb-1">Layanan Legal</p>
                        <div class="flex flex-wrap gap-1.5">
                            @if($order->include_bpom)<span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">BPOM</span>@endif
                            @if($order->include_halal)<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Halal</span>@endif
                            @if($order->include_logo)<span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">Desain Logo</span>@endif
                            @if($order->include_haki)<span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">HAKI</span>@endif
                            @if(!$order->include_bpom && !$order->include_halal && !$order->include_logo && !$order->include_haki)<span class="text-slate-400 text-xs">Tidak ada</span>@endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk Summary --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-lg">science</span>Produk</h3>
                    <a href="{{ route('orders.show', [$order, 'step' => 2]) }}" class="text-xs text-primary font-semibold hover:underline">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><p class="text-xs text-slate-400">Produk</p><p class="font-semibold text-slate-800">{{ $order->product?->name ?? '-' }}</p></div>
                    <div><p class="text-xs text-slate-400">Volume</p><p class="font-semibold text-slate-800">{{ $order->volume_ml }} ml / unit</p></div>
                </div>
            </div>

            {{-- Kemasan Summary --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-lg">inventory_2</span>Kemasan & Kuantitas</h3>
                    <a href="{{ route('orders.show', [$order, 'step' => 4]) }}" class="text-xs text-primary font-semibold hover:underline">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><p class="text-xs text-slate-400">Kemasan</p><p class="font-semibold text-slate-800">{{ $order->packagingType?->name ?? '-' }}</p></div>
                    <div><p class="text-xs text-slate-400">Jumlah</p><p class="font-semibold text-slate-800">{{ number_format($order->quantity) }} pcs</p></div>
                </div>
            </div>

            {{-- Biaya Breakdown --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-lg">receipt_long</span>Estimasi Biaya</h3>
                <div class="space-y-2 text-sm">
                    @if($order->base_cost > 0)
                    <div class="flex justify-between"><span class="text-slate-500">Biaya Produk Dasar</span><span class="font-medium text-slate-800">{{ $rp($order->base_cost) }}</span></div>
                    @endif
                    @if($order->material_cost > 0)
                    <div class="flex justify-between"><span class="text-slate-500">Biaya Bahan Aktif</span><span class="font-medium text-slate-800">{{ $rp($order->material_cost) }}</span></div>
                    @endif
                    @if($order->packaging_cost > 0)
                    <div class="flex justify-between"><span class="text-slate-500">Biaya Kemasan</span><span class="font-medium text-slate-800">{{ $rp($order->packaging_cost) }}</span></div>
                    @endif
                    @if($order->design_cost > 0)
                    <div class="flex justify-between"><span class="text-slate-500">Jasa Desain</span><span class="font-medium text-slate-800">{{ $rp($order->design_cost) }}</span></div>
                    @endif
                    @if($order->legal_cost > 0)
                    <div class="flex justify-between"><span class="text-slate-500">Biaya Legal / Sertifikasi</span><span class="font-medium text-slate-800">{{ $rp($order->legal_cost) }}</span></div>
                    @endif
                    <div class="flex justify-between"><span class="text-slate-500">PPN 11%</span><span class="font-medium text-slate-800">{{ $rp($order->ppn) }}</span></div>
                    @if($order->sample_cost > 0)
                    <div class="flex justify-between"><span class="text-slate-500">Biaya Sampel</span><span class="font-medium text-slate-800">{{ $rp($order->sample_cost) }}</span></div>
                    @endif
                    <div class="border-t border-slate-100 pt-3 mt-3 space-y-2">
                        <div class="flex justify-between font-bold"><span class="text-slate-800">Total Estimasi</span><span class="text-slate-900 text-base">{{ $rp($order->total_amount) }}</span></div>
                        <div class="flex justify-between text-sm"><span class="text-slate-500">DP (bayar sekarang)</span><span class="font-bold text-primary">{{ $rp($order->dp_amount) }}</span></div>
                        <div class="flex justify-between text-sm"><span class="text-slate-500">Pelunasan (setelah produksi)</span><span class="font-medium text-slate-600">{{ $rp($order->remaining_amount) }}</span></div>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4">* Estimasi dapat berubah setelah admin melakukan review dan konfirmasi</p>
            </div>

            <form method="POST" action="{{ route('orders.step', $order) }}" class="space-y-4">
                @csrf @method('PUT')
                <input type="hidden" name="step" value="6">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                    <span class="material-symbols-outlined text-amber-500 flex-shrink-0">info</span>
                    <p class="text-sm text-amber-700">Dengan menekan <strong>Submit Order</strong>, Anda menyetujui untuk melanjutkan proses pembuatan produk sesuai detail di atas. Tim kami akan menghubungi Anda dalam 1x24 jam.</p>
                </div>
                <div class="flex items-center justify-between">
                    <a href="{{ route('orders.show', [$order, 'step' => 5]) }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
                    </a>
                    <button type="submit" class="bg-emerald-600 text-white px-10 py-3.5 rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-md flex items-center gap-2 text-base">
                        <span class="material-symbols-outlined">send</span> Submit Order
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    {{-- ============================= DETAIL MODE (ACTIVE ORDER) ============================= --}}
    @else
    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Order Header --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold text-primary">#{{ $order->order_number }}</h2>
                    <p class="text-slate-500 text-sm mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $order->statusColor() }}">
                    {{ $order->statusLabel() }}
                </span>
            </div>

            <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4 pt-6 border-t border-slate-100">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Produk</p>
                    <p class="font-semibold text-slate-800 mt-1">{{ $order->product?->name ?? $order->product_name ?? '-' }}</p>
                    @if($order->brand_name)<p class="text-xs text-slate-400">Brand: {{ $order->brand_name }}</p>@endif
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Jumlah</p>
                    <p class="font-semibold text-slate-800 mt-1">{{ number_format($order->quantity) }} Pcs</p>
                </div>
                @if($order->total_amount > 0)
                <div>
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Total Estimasi</p>
                    <p class="font-semibold text-slate-800 mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- MOU Section --}}
        @if(in_array($order->status, ['confirmed','in_progress','completed']))
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span> Dokumen MOU
                </h3>
                <a href="{{ route('mou.show', $order) }}" class="text-primary text-sm font-semibold hover:underline">Kelola MOU →</a>
            </div>
            <div class="mt-3">
                @php $mouStatusColor = match($order->mou_status) { 'approved' => 'text-emerald-600', 'signed' => 'text-blue-600', 'waiting' => 'text-amber-600', default => 'text-slate-400' }; @endphp
                <span class="text-sm font-medium {{ $mouStatusColor }}">
                    {{ match($order->mou_status) { 'approved' => '✓ MOU Disetujui', 'signed' => '⏳ MOU Menunggu Verifikasi', 'waiting' => '⚠ Belum Ditandatangani', default => '— Belum Ada MOU' } }}
                </span>
            </div>
        </div>
        @endif

        {{-- Production Progress --}}
        @if($order->production_status)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-5">Progress Produksi</h3>
            @php
                $prodSteps = ['antri'=>'Antri','mixing'=>'Mixing','qc'=>'QC','packing'=>'Packing','siap_kirim'=>'Siap Kirim','terkirim'=>'Terkirim'];
                $prodKeys = array_keys($prodSteps);
                $prodIdx = array_search($order->production_status, $prodKeys);
            @endphp
            <div class="flex items-center">
                @foreach($prodSteps as $k => $l)
                @php $i = array_search($k, $prodKeys); @endphp
                <div class="flex flex-col items-center {{ $i < count($prodSteps) - 1 ? 'flex-1' : '' }}">
                    <div class="size-8 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $i < $prodIdx ? 'bg-emerald-500 text-white' : ($i == $prodIdx ? 'bg-primary text-white ring-4 ring-primary/20' : 'bg-slate-100 text-slate-400') }}">
                        @if($i < $prodIdx)<span class="material-symbols-outlined text-sm">check</span>@else{{ $i+1 }}@endif
                    </div>
                    <p class="text-[9px] mt-1.5 font-medium {{ $i == $prodIdx ? 'text-primary' : 'text-slate-400' }}">{{ $l }}</p>
                </div>
                @if($i < count($prodSteps) - 1)
                <div class="flex-1 h-0.5 {{ $i < $prodIdx ? 'bg-emerald-400' : 'bg-slate-200' }} mb-4"></div>
                @endif
                @endforeach
            </div>
            @if($order->tracking_number)
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-slate-400">local_shipping</span>
                <div>
                    <p class="text-slate-500">Nomor Resi: <span class="font-bold text-slate-800">{{ $order->tracking_number }}</span></p>
                    @if($order->courier)<p class="text-xs text-slate-400">{{ $order->courier }}</p>@endif
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Status Timeline (for non-production orders) --}}
        @if($order->status === 'pending')
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 flex gap-3">
            <span class="material-symbols-outlined text-amber-500 flex-shrink-0">schedule</span>
            <div>
                <p class="font-semibold text-amber-800">Menunggu Konfirmasi Admin</p>
                <p class="text-sm text-amber-700 mt-1">Tim kami sedang mereview order Anda. Kami akan menghubungi Anda dalam 1x24 jam.</p>
            </div>
        </div>
        @endif

        {{-- Invoice Section --}}
        @php $latestInvoice = $order->invoices->first(); @endphp
        @if($latestInvoice)
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-800">Invoice</h3>
                <a href="{{ route('invoices.show', $latestInvoice) }}" class="text-primary text-sm font-semibold hover:underline">Lihat Detail</a>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">{{ $latestInvoice->invoice_number ?? '#INV-' . $latestInvoice->id }}</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">Rp {{ number_format($latestInvoice->amount, 0, ',', '.') }}</p>
                    @if($latestInvoice->due_date)<p class="text-xs text-slate-400 mt-0.5">Jatuh tempo: {{ \Carbon\Carbon::parse($latestInvoice->due_date)->format('d M Y') }}</p>@endif
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $latestInvoice->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $latestInvoice->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                    @if($latestInvoice->status !== 'paid')
                    <a href="{{ route('payments.create', $latestInvoice) }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">
                        Bayar Sekarang
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @elseif($order->status === 'confirmed')
        <div class="bg-slate-50 rounded-xl border border-slate-200 border-dashed p-6 text-center">
            <span class="material-symbols-outlined text-3xl text-slate-300">receipt_long</span>
            <p class="text-slate-500 text-sm mt-2">Invoice akan dibuat setelah MOU disetujui</p>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('orders.index') }}" class="text-sm text-slate-500 hover:text-slate-700 font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
            </a>
            @if($order->status === 'completed')
            <form method="POST" action="{{ route('orders.duplicate', $order) }}" class="ml-auto">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-700 rounded-lg text-sm font-semibold hover:border-primary hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-base">content_copy</span> Duplikasi Order
                </button>
            </form>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection
