<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\LegalDocument;
use App\Models\Material;
use App\Models\MouDocument;
use App\Models\Order;
use App\Models\PackagingType;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ENUM status orders sudah benar sebelum insert (MySQL only)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status
                ENUM('draft','pending','confirmed','in_progress','completed','cancelled')
                NOT NULL DEFAULT 'draft'");
        }

        Schema::disableForeignKeyConstraints();
        Payment::truncate();
        Invoice::truncate();
        MouDocument::truncate();
        LegalDocument::truncate();
        Order::truncate();
        User::whereNotIn('email', [
            'superadmin@maklon.id', 'admin@maklon.id',
            'user@maklon.id', 'newuser@maklon.id',
        ])->delete();
        Schema::enableForeignKeyConstraints();

        // ──────────────────────────────────────────────────
        // USERS
        // ──────────────────────────────────────────────────
        $users = $this->seedUsers();

        // ──────────────────────────────────────────────────
        // LEGAL DOCUMENTS
        // ──────────────────────────────────────────────────
        $this->seedLegalDocuments($users);

        // ──────────────────────────────────────────────────
        // ORDERS
        // ──────────────────────────────────────────────────
        $this->seedOrders($users);
    }

    private function seedUsers(): array
    {
        $maya = User::updateOrCreate(['email' => 'maya@beautylab.id'], [
            'name'                => 'Maya Dewi Anggraini',
            'phone'               => '081345678901',
            'company_name'        => 'CV Beauty Lab Indonesia',
            'role'                => 'user',
            'is_active'           => true,
            'email_verified_at'   => now()->subDays(10),
            'verification_status' => 'pending',
            'business_type'       => 'CV',
            'address'             => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
            'password'            => Hash::make('user123'),
        ]);

        $ahmad = User::updateOrCreate(['email' => 'ahmad@naturalskin.id'], [
            'name'                => 'Ahmad Fauzi Hakim',
            'phone'               => '082234567890',
            'company_name'        => 'PT Natural Skin Indonesia',
            'role'                => 'user',
            'is_active'           => true,
            'email_verified_at'   => now()->subDays(30),
            'verification_status' => 'verified',
            'verified_at'         => now()->subDays(25),
            'business_type'       => 'PT',
            'npwp'                => '23.456.789.0-123.000',
            'address'             => 'Jl. Raya Bogor No. 120, Depok',
            'password'            => Hash::make('user123'),
        ]);

        $indah = User::updateOrCreate(['email' => 'indah@glowup.id'], [
            'name'                => 'Indah Permata Sari',
            'phone'               => '087756789012',
            'company_name'        => 'Glowup Beauty Studio',
            'role'                => 'user',
            'is_active'           => true,
            'email_verified_at'   => now()->subDays(20),
            'verification_status' => 'verified',
            'verified_at'         => now()->subDays(15),
            'business_type'       => 'CV',
            'npwp'                => '34.567.890.1-234.000',
            'address'             => 'Jl. Kemang Raya No. 88, Jakarta Selatan',
            'password'            => Hash::make('user123'),
        ]);

        $reza = User::updateOrCreate(['email' => 'reza@herbalcare.id'], [
            'name'                => 'Reza Nugraha',
            'phone'               => '085678901234',
            'company_name'        => 'CV Herbal Care Nusantara',
            'role'                => 'user',
            'is_active'           => true,
            'email_verified_at'   => now()->subDays(5),
            'verification_status' => 'rejected',
            'verification_notes'  => 'Dokumen akta tidak terbaca, mohon upload ulang dengan kualitas yang lebih baik.',
            'business_type'       => 'CV',
            'address'             => 'Jl. Pahlawan No. 33, Surabaya',
            'password'            => Hash::make('user123'),
        ]);

        $dewi = User::updateOrCreate(['email' => 'dewi@skincare.id'], [
            'name'                => 'Dewi Lestari',
            'phone'               => '089912345678',
            'company_name'        => 'PT Dewi Skincare',
            'role'                => 'user',
            'is_active'           => true,
            'email_verified_at'   => now()->subDays(45),
            'verification_status' => 'verified',
            'verified_at'         => now()->subDays(40),
            'business_type'       => 'PT',
            'npwp'                => '45.678.901.2-345.000',
            'address'             => 'Jl. Ahmad Yani No. 77, Bandung',
            'password'            => Hash::make('user123'),
        ]);

        $budi   = User::where('email', 'user@maklon.id')->first();
        $newUser = User::where('email', 'newuser@maklon.id')->first();

        return compact('budi', 'newUser', 'maya', 'ahmad', 'indah', 'reza', 'dewi');
    }

    private function seedLegalDocuments(array $users): void
    {
        $admin = User::where('role', 'admin')->first();

        $docSets = [
            // verified users
            [$users['budi'],  'approved', $admin],
            [$users['ahmad'], 'approved', $admin],
            [$users['indah'], 'approved', $admin],
            [$users['dewi'],  'approved', $admin],
            // pending
            [$users['maya'],    'pending',  null],
            [$users['newUser'], 'pending',  null],
            // rejected
            [$users['reza'], 'rejected', $admin],
        ];

        foreach ($docSets as [$user, $status, $reviewer]) {
            if (!$user) continue;
            foreach (['akta_pendirian', 'nib', 'siup'] as $type) {
                LegalDocument::create([
                    'user_id'       => $user->id,
                    'type'          => $type,
                    'file_path'     => "documents/{$user->id}/{$type}.pdf",
                    'original_name' => ucfirst(str_replace('_', ' ', $type)) . '.pdf',
                    'status'        => $status,
                    'notes'         => $status === 'rejected' ? 'Dokumen tidak terbaca, mohon upload ulang.' : null,
                    'reviewed_by'   => $reviewer?->id,
                    'reviewed_at'   => $reviewer ? now()->subDays(2) : null,
                    'created_at'    => now()->subDays(rand(5, 30)),
                    'updated_at'    => now()->subDays(rand(1, 4)),
                ]);
            }
        }
    }

    private function seedOrders(array $users): void
    {
        // Reference data
        $products     = Product::all()->keyBy('name');
        $materials    = Material::all()->keyBy('name');
        $packagings   = PackagingType::all();
        $pumpSmall    = $packagings->where('name', 'Botol Pump 30ml')->first()   ?? $packagings->first();
        $pumpMed      = $packagings->where('name', 'Botol Pump 50ml')->first()   ?? $packagings->first();
        $pumpLarge    = $packagings->where('name', 'Botol Pump 100ml')->first()  ?? $packagings->first();
        $tubeMed      = $packagings->where('name', 'Tube 50ml')->first()         ?? $packagings->first();
        $jarSmall     = $packagings->where('name', 'Jar 30g')->first()           ?? $packagings->first();
        $jarMed       = $packagings->where('name', 'Jar 50g')->first()           ?? $packagings->first();
        $dropperSmall = $packagings->where('name', 'Dropper 15ml')->first()      ?? $packagings->first();
        $sachet       = $packagings->where('name', 'Sachet 5ml')->first()        ?? $packagings->first();

        $getProduct = fn(string $name) => Product::where('name', 'like', "%{$name}%")->first();
        $getMat     = fn(string $name) => Material::where('name', 'like', "%{$name}%")->first();

        $ceramide    = $getMat('Ceramide');
        $vitC        = $getMat('Vitamin C') ?? $getMat('Vitamin');
        $hyaluronic  = $getMat('Hyaluronic') ?? $getMat('4D Hyaluronic');
        $aloeVera    = $getMat('Aloe Vera');
        $niacinamide = $getMat('Niacinamide') ?? $getMat('Kojic');
        $kojicAcid   = $getMat('Kojic Acid') ?? $getMat('Kojic');
        $roseOil     = $getMat('Rose') ?? $getMat('Lavender');
        $salicylic   = $getMat('Salicylic') ?? $getMat('Active');
        $collagen    = $getMat('Collagen') ?? $getMat('Fish Collagen');
        $adminUser   = User::where('role', 'admin')->first();

        // ── ORDER 1: Budi – Serum Vitamin C – COMPLETED ──────────────────
        $p1 = $getProduct('Serum') ?? Product::first();
        $selectedMat1 = [];
        if ($ceramide)   $selectedMat1[] = ['material_id' => $ceramide->id,   'dose_ml' => 0.5];
        if ($vitC)       $selectedMat1[] = ['material_id' => $vitC->id,       'dose_ml' => 0.3];
        if ($hyaluronic) $selectedMat1[] = ['material_id' => $hyaluronic->id, 'dose_ml' => 0.2];

        $o1BaseCost    = 3000000;
        $o1MatCost     = 2200000;
        $o1PkgCost     = 500000;
        $o1DesignCost  = 750000;
        $o1SampleCost  = 500000;
        $o1LegalCost   = 5250000;
        $o1Subtotal    = $o1BaseCost + $o1MatCost + $o1PkgCost + $o1DesignCost + $o1SampleCost;
        $o1Ppn         = ($o1Subtotal + $o1LegalCost) * 0.11;
        $o1Total       = $o1Subtotal + $o1LegalCost + $o1Ppn;
        $o1Dp          = $o1LegalCost + $o1SampleCost + ($o1Subtotal * 0.5);
        $o1Sisa        = $o1Subtotal * 0.5;

        $order1 = Order::create([
            'user_id'           => $users['budi']->id,
            'order_number'      => 'MKL-2026-0001',
            'product_name'      => 'Serum Vitamin C 30ml',
            'product_type'      => 'serum',
            'quantity'          => 1000,
            'status'            => 'completed',
            'notes'             => 'Produk sudah selesai diproduksi dan dikirim.',
            'brand_type'        => 'haki',
            'brand_name'        => 'GlowEssence',
            'include_bpom'      => true,
            'include_halal'     => true,
            'include_logo'      => true,
            'include_haki'      => true,
            'product_id'        => $p1?->id,
            'volume_ml'         => 30,
            'selected_materials'=> json_encode($selectedMat1),
            'packaging_type_id' => $dropperSmall?->id,
            'design_option'     => 'jasa_desain',
            'design_description'=> 'Tema minimalis modern dengan warna gold dan putih',
            'request_sample'    => true,
            'legal_cost'        => $o1LegalCost,
            'base_cost'         => $o1BaseCost,
            'material_cost'     => $o1MatCost,
            'packaging_cost'    => $o1PkgCost,
            'design_cost'       => $o1DesignCost,
            'sample_cost'       => $o1SampleCost,
            'ppn'               => $o1Ppn,
            'total_amount'      => $o1Total,
            'dp_amount'         => $o1Dp,
            'remaining_amount'  => $o1Sisa,
            'production_status' => 'terkirim',
            'tracking_number'   => 'JNE12345678',
            'courier'           => 'JNE',
            'current_step'      => 6,
            'mou_status'        => 'approved',
            'confirmed_at'      => now()->subDays(60),
            'completed_at'      => now()->subDays(5),
            'created_at'        => now()->subDays(75),
            'updated_at'        => now()->subDays(5),
        ]);

        $mou1 = MouDocument::create([
            'order_id'    => $order1->id,
            'status'      => 'approved',
            'notes'       => 'MOU disetujui. Semua dokumen lengkap dan valid.',
            'reviewed_by' => $adminUser?->id,
            'reviewed_at' => now()->subDays(70),
            'created_at'  => now()->subDays(73),
            'updated_at'  => now()->subDays(70),
        ]);

        $inv1dp = Invoice::create([
            'order_id'       => $order1->id,
            'user_id'        => $users['budi']->id,
            'invoice_number' => 'INV-2026-0001-DP',
            'amount'         => $o1Dp,
            'status'         => 'paid',
            'due_date'       => now()->subDays(65)->toDateString(),
            'paid_at'        => now()->subDays(68),
            'notes'          => 'Pembayaran DP 50% + Legalitas',
            'created_at'     => now()->subDays(72),
        ]);
        Payment::create([
            'invoice_id' => $inv1dp->id,
            'user_id'    => $users['budi']->id,
            'amount'     => $o1Dp,
            'method'     => 'transfer',
            'proof_file' => 'payments/bukti_transfer_001.jpg',
            'status'     => 'verified',
            'notes'      => 'Transfer BCA verified.',
            'created_at' => now()->subDays(68),
        ]);

        $inv1pel = Invoice::create([
            'order_id'       => $order1->id,
            'user_id'        => $users['budi']->id,
            'invoice_number' => 'INV-2026-0001-PEL',
            'amount'         => $o1Sisa,
            'status'         => 'paid',
            'due_date'       => now()->subDays(10)->toDateString(),
            'paid_at'        => now()->subDays(8),
            'notes'          => 'Pelunasan 50%',
            'created_at'     => now()->subDays(15),
        ]);
        Payment::create([
            'invoice_id' => $inv1pel->id,
            'user_id'    => $users['budi']->id,
            'amount'     => $o1Sisa,
            'method'     => 'transfer',
            'proof_file' => 'payments/bukti_pelunasan_001.jpg',
            'status'     => 'verified',
            'notes'      => 'Transfer Mandiri verified.',
            'created_at' => now()->subDays(8),
        ]);

        // ── ORDER 2: Budi – Body Lotion – IN_PROGRESS ───────────────────
        $p2 = $getProduct('Body Lotion') ?? Product::skip(1)->first();
        $selectedMat2 = [];
        if ($aloeVera)   $selectedMat2[] = ['material_id' => $aloeVera->id,   'dose_ml' => 1.0];
        if ($ceramide)   $selectedMat2[] = ['material_id' => $ceramide->id,   'dose_ml' => 0.3];

        $o2BaseCost   = 2500000;
        $o2MatCost    = 950000;
        $o2PkgCost    = 800000;
        $o2DesignCost = 750000;
        $o2LegalCost  = 2500000;
        $o2Subtotal   = $o2BaseCost + $o2MatCost + $o2PkgCost + $o2DesignCost;
        $o2Ppn        = ($o2Subtotal + $o2LegalCost) * 0.11;
        $o2Total      = $o2Subtotal + $o2LegalCost + $o2Ppn;
        $o2Dp         = $o2LegalCost + ($o2Subtotal * 0.5);
        $o2Sisa       = $o2Subtotal * 0.5;

        $order2 = Order::create([
            'user_id'           => $users['budi']->id,
            'order_number'      => 'MKL-2026-0002',
            'product_name'      => 'Body Lotion Aloe 200ml',
            'product_type'      => 'body_lotion',
            'quantity'          => 500,
            'status'            => 'in_progress',
            'notes'             => 'Proses produksi sedang berjalan.',
            'brand_type'        => 'haki',
            'brand_name'        => 'GlowEssence',
            'include_bpom'      => true,
            'include_halal'     => false,
            'include_logo'      => false,
            'include_haki'      => false,
            'product_id'        => $p2?->id,
            'volume_ml'         => 200,
            'selected_materials'=> json_encode($selectedMat2),
            'packaging_type_id' => $pumpMed?->id,
            'design_option'     => 'upload_sendiri',
            'design_file_url'   => 'https://drive.google.com/file/sample',
            'request_sample'    => false,
            'legal_cost'        => $o2LegalCost,
            'base_cost'         => $o2BaseCost,
            'material_cost'     => $o2MatCost,
            'packaging_cost'    => $o2PkgCost,
            'design_cost'       => $o2DesignCost,
            'sample_cost'       => 0,
            'ppn'               => $o2Ppn,
            'total_amount'      => $o2Total,
            'dp_amount'         => $o2Dp,
            'remaining_amount'  => $o2Sisa,
            'production_status' => 'qc',
            'current_step'      => 6,
            'mou_status'        => 'approved',
            'confirmed_at'      => now()->subDays(30),
            'created_at'        => now()->subDays(40),
            'updated_at'        => now()->subDays(2),
        ]);

        MouDocument::create([
            'order_id'    => $order2->id,
            'status'      => 'approved',
            'reviewed_by' => $adminUser?->id,
            'reviewed_at' => now()->subDays(33),
            'created_at'  => now()->subDays(38),
        ]);

        $inv2dp = Invoice::create([
            'order_id'       => $order2->id,
            'user_id'        => $users['budi']->id,
            'invoice_number' => 'INV-2026-0002-DP',
            'amount'         => $o2Dp,
            'status'         => 'paid',
            'due_date'       => now()->subDays(28)->toDateString(),
            'paid_at'        => now()->subDays(30),
            'notes'          => 'Pembayaran DP 50% + Legalitas',
            'created_at'     => now()->subDays(35),
        ]);
        Payment::create([
            'invoice_id' => $inv2dp->id,
            'user_id'    => $users['budi']->id,
            'amount'     => $o2Dp,
            'method'     => 'qris',
            'proof_file' => 'payments/bukti_transfer_002.jpg',
            'status'     => 'verified',
            'created_at' => now()->subDays(30),
        ]);

        Invoice::create([
            'order_id'       => $order2->id,
            'user_id'        => $users['budi']->id,
            'invoice_number' => 'INV-2026-0002-PEL',
            'amount'         => $o2Sisa,
            'status'         => 'pending',
            'due_date'       => now()->addDays(14)->toDateString(),
            'notes'          => 'Pelunasan akan dibuka setelah produksi selesai.',
            'created_at'     => now()->subDays(5),
        ]);

        // ── ORDER 3: Ahmad – Facial Wash – PENDING ───────────────────────
        $p3 = $getProduct('Facial Wash') ?? Product::skip(2)->first();
        $selectedMat3 = [];
        if ($salicylic) $selectedMat3[] = ['material_id' => $salicylic->id, 'dose_ml' => 0.5];
        if ($aloeVera)  $selectedMat3[] = ['material_id' => $aloeVera->id,  'dose_ml' => 1.0];

        $o3BaseCost  = 1800000;
        $o3MatCost   = 650000;
        $o3PkgCost   = 350000;
        $o3LegalCost = 1250000;
        $o3Subtotal  = $o3BaseCost + $o3MatCost + $o3PkgCost;
        $o3Ppn       = ($o3Subtotal + $o3LegalCost) * 0.11;
        $o3Total     = $o3Subtotal + $o3LegalCost + $o3Ppn;
        $o3Dp        = $o3LegalCost + ($o3Subtotal * 0.5);
        $o3Sisa      = $o3Subtotal * 0.5;

        $order3 = Order::create([
            'user_id'           => $users['ahmad']->id,
            'order_number'      => 'MKL-2026-0003',
            'product_name'      => 'Facial Wash Acne Care 100ml',
            'product_type'      => 'facial_wash',
            'quantity'          => 300,
            'status'            => 'pending',
            'notes'             => null,
            'brand_type'        => 'undername',
            'brand_name'        => 'NaturalSkin Pro',
            'include_bpom'      => true,
            'include_halal'     => true,
            'include_logo'      => false,
            'include_haki'      => false,
            'product_id'        => $p3?->id,
            'volume_ml'         => 100,
            'selected_materials'=> json_encode($selectedMat3),
            'packaging_type_id' => $tubeMed?->id,
            'design_option'     => 'upload_sendiri',
            'request_sample'    => true,
            'sample_cost'       => 500000,
            'legal_cost'        => $o3LegalCost,
            'base_cost'         => $o3BaseCost,
            'material_cost'     => $o3MatCost,
            'packaging_cost'    => $o3PkgCost,
            'design_cost'       => 0,
            'ppn'               => $o3Ppn,
            'total_amount'      => $o3Total,
            'dp_amount'         => $o3Dp,
            'remaining_amount'  => $o3Sisa,
            'current_step'      => 6,
            'mou_status'        => 'waiting',
            'created_at'        => now()->subDays(3),
            'updated_at'        => now()->subDays(1),
        ]);

        MouDocument::create([
            'order_id'   => $order3->id,
            'status'     => 'signed_uploaded',
            'signed_pdf' => 'mou/mou_order3_signed.pdf',
            'notes'      => null,
            'created_at' => now()->subDays(1),
        ]);

        $inv3dp = Invoice::create([
            'order_id'       => $order3->id,
            'user_id'        => $users['ahmad']->id,
            'invoice_number' => 'INV-2026-0003-DP',
            'amount'         => $o3Dp,
            'status'         => 'pending',
            'due_date'       => now()->addDays(7)->toDateString(),
            'notes'          => 'Menunggu verifikasi MOU sebelum pembayaran diproses.',
            'created_at'     => now()->subDays(2),
        ]);

        Payment::create([
            'invoice_id' => $inv3dp->id,
            'user_id'    => $users['ahmad']->id,
            'amount'     => $o3Dp,
            'method'     => 'transfer',
            'proof_file' => 'payments/bukti_transfer_003.jpg',
            'status'     => 'pending',
            'notes'      => 'Menunggu verifikasi admin.',
            'created_at' => now()->subDays(1),
        ]);

        // ── ORDER 4: Ahmad – Shampoo – CONFIRMED ─────────────────────────
        $p4 = $getProduct('Shampoo') ?? Product::skip(3)->first();
        $selectedMat4 = [];
        if ($aloeVera) $selectedMat4[] = ['material_id' => $aloeVera->id, 'dose_ml' => 2.0];

        $o4BaseCost  = 2200000;
        $o4MatCost   = 550000;
        $o4PkgCost   = 650000;
        $o4LegalCost = 1250000;
        $o4Subtotal  = $o4BaseCost + $o4MatCost + $o4PkgCost;
        $o4Ppn       = ($o4Subtotal + $o4LegalCost) * 0.11;
        $o4Total     = $o4Subtotal + $o4LegalCost + $o4Ppn;
        $o4Dp        = $o4LegalCost + ($o4Subtotal * 0.5);
        $o4Sisa      = $o4Subtotal * 0.5;

        $order4 = Order::create([
            'user_id'           => $users['ahmad']->id,
            'order_number'      => 'MKL-2026-0004',
            'product_name'      => 'Shampoo Anti Dandruff 200ml',
            'product_type'      => 'shampoo',
            'quantity'          => 500,
            'status'            => 'confirmed',
            'brand_type'        => 'undername',
            'brand_name'        => 'NaturalSkin Pro',
            'include_bpom'      => true,
            'include_halal'     => true,
            'product_id'        => $p4?->id,
            'volume_ml'         => 200,
            'selected_materials'=> json_encode($selectedMat4),
            'packaging_type_id' => $pumpLarge?->id,
            'design_option'     => 'upload_sendiri',
            'legal_cost'        => $o4LegalCost,
            'base_cost'         => $o4BaseCost,
            'material_cost'     => $o4MatCost,
            'packaging_cost'    => $o4PkgCost,
            'ppn'               => $o4Ppn,
            'total_amount'      => $o4Total,
            'dp_amount'         => $o4Dp,
            'remaining_amount'  => $o4Sisa,
            'production_status' => 'antri',
            'current_step'      => 6,
            'mou_status'        => 'approved',
            'confirmed_at'      => now()->subDays(7),
            'created_at'        => now()->subDays(14),
        ]);

        MouDocument::create([
            'order_id'    => $order4->id,
            'status'      => 'approved',
            'reviewed_by' => $adminUser?->id,
            'reviewed_at' => now()->subDays(9),
            'created_at'  => now()->subDays(12),
        ]);

        $inv4dp = Invoice::create([
            'order_id'       => $order4->id,
            'user_id'        => $users['ahmad']->id,
            'invoice_number' => 'INV-2026-0004-DP',
            'amount'         => $o4Dp,
            'status'         => 'paid',
            'due_date'       => now()->subDays(5)->toDateString(),
            'paid_at'        => now()->subDays(7),
            'created_at'     => now()->subDays(11),
        ]);
        Payment::create([
            'invoice_id' => $inv4dp->id,
            'user_id'    => $users['ahmad']->id,
            'amount'     => $o4Dp,
            'method'     => 'virtual_account',
            'proof_file' => 'payments/bukti_va_004.jpg',
            'status'     => 'verified',
            'created_at' => now()->subDays(7),
        ]);

        // ── ORDER 5: Indah – Lip Matte – PENDING MOU ─────────────────────
        $p5 = $getProduct('Lip') ?? Product::skip(4)->first();
        $selectedMat5 = [];
        if ($roseOil) $selectedMat5[] = ['material_id' => $roseOil->id, 'dose_ml' => 0.5];

        $o5LegalCost = 3750000;
        $o5Base      = 1200000; $o5Mat = 420000; $o5Pkg = 300000; $o5Des = 750000;
        $o5Subtotal  = $o5Base + $o5Mat + $o5Pkg + $o5Des;
        $o5Ppn       = ($o5Subtotal + $o5LegalCost) * 0.11;
        $o5Total     = $o5Subtotal + $o5LegalCost + $o5Ppn;
        $o5Dp        = $o5LegalCost + ($o5Subtotal * 0.5);

        $order5 = Order::create([
            'user_id'           => $users['indah']->id,
            'order_number'      => 'MKL-2026-0005',
            'product_name'      => 'Lip Matte 4ml',
            'product_type'      => 'lip_matte',
            'quantity'          => 200,
            'status'            => 'pending',
            'brand_type'        => 'haki',
            'brand_name'        => 'GlowUp Cosmetics',
            'include_bpom'      => true,
            'include_halal'     => true,
            'include_logo'      => true,
            'product_id'        => $p5?->id,
            'volume_ml'         => 4,
            'selected_materials'=> json_encode($selectedMat5),
            'packaging_type_id' => $jarSmall?->id,
            'design_option'     => 'jasa_desain',
            'design_description'=> 'Warna nude modern dengan gradasi rose gold',
            'legal_cost'        => $o5LegalCost,
            'base_cost'         => $o5Base,
            'material_cost'     => $o5Mat,
            'packaging_cost'    => $o5Pkg,
            'design_cost'       => $o5Des,
            'ppn'               => $o5Ppn,
            'total_amount'      => $o5Total,
            'dp_amount'         => $o5Dp,
            'remaining_amount'  => $o5Subtotal * 0.5,
            'current_step'      => 6,
            'mou_status'        => 'draft',
            'created_at'        => now()->subDays(2),
        ]);

        MouDocument::create([
            'order_id'   => $order5->id,
            'status'     => 'waiting_signature',
            'created_at' => now()->subDays(2),
        ]);

        Invoice::create([
            'order_id'       => $order5->id,
            'user_id'        => $users['indah']->id,
            'invoice_number' => 'INV-2026-0005-DP',
            'amount'         => $o5Dp,
            'status'         => 'pending',
            'due_date'       => now()->addDays(14)->toDateString(),
            'notes'          => 'Menunggu MOU ditandatangani.',
            'created_at'     => now()->subDays(2),
        ]);

        // ── ORDER 6: Dewi – Moisturizer – COMPLETED ──────────────────────
        $p6 = $getProduct('Moisturizer') ?? Product::skip(5)->first();
        $selectedMat6 = [];
        if ($hyaluronic) $selectedMat6[] = ['material_id' => $hyaluronic->id, 'dose_ml' => 0.5];
        if ($niacinamide) $selectedMat6[] = ['material_id' => $niacinamide->id, 'dose_ml' => 0.3];
        if ($ceramide)   $selectedMat6[] = ['material_id' => $ceramide->id,    'dose_ml' => 0.2];

        $o6LegalCost = 2500000;
        $o6Base = 2800000; $o6Mat = 1500000; $o6Pkg = 450000; $o6Des = 750000; $o6Sam = 500000;
        $o6Sub  = $o6Base + $o6Mat + $o6Pkg + $o6Des + $o6Sam;
        $o6Ppn  = ($o6Sub + $o6LegalCost) * 0.11;
        $o6Total = $o6Sub + $o6LegalCost + $o6Ppn;
        $o6Dp    = $o6LegalCost + $o6Sam + ($o6Sub * 0.5);
        $o6Sisa  = $o6Sub * 0.5;

        $order6 = Order::create([
            'user_id'           => $users['dewi']->id,
            'order_number'      => 'MKL-2025-0006',
            'product_name'      => 'Moisturizer Niacinamide 30ml',
            'product_type'      => 'moisturizer',
            'quantity'          => 1000,
            'status'            => 'completed',
            'brand_type'        => 'haki',
            'brand_name'        => 'Dewi Beauty',
            'include_bpom'      => true,
            'include_halal'     => true,
            'include_logo'      => true,
            'include_haki'      => true,
            'product_id'        => $p6?->id,
            'volume_ml'         => 30,
            'selected_materials'=> json_encode($selectedMat6),
            'packaging_type_id' => $jarMed?->id,
            'design_option'     => 'jasa_desain',
            'request_sample'    => true,
            'sample_cost'       => $o6Sam,
            'legal_cost'        => $o6LegalCost,
            'base_cost'         => $o6Base,
            'material_cost'     => $o6Mat,
            'packaging_cost'    => $o6Pkg,
            'design_cost'       => $o6Des,
            'ppn'               => $o6Ppn,
            'total_amount'      => $o6Total,
            'dp_amount'         => $o6Dp,
            'remaining_amount'  => $o6Sisa,
            'production_status' => 'terkirim',
            'tracking_number'   => 'SICEPAT98765',
            'courier'           => 'SiCepat',
            'current_step'      => 6,
            'mou_status'        => 'approved',
            'confirmed_at'      => now()->subMonths(2),
            'completed_at'      => now()->subDays(20),
            'created_at'        => now()->subMonths(3),
        ]);

        MouDocument::create([
            'order_id'    => $order6->id,
            'status'      => 'approved',
            'reviewed_by' => $adminUser?->id,
            'reviewed_at' => now()->subDays(85),
            'created_at'  => now()->subMonths(3),
        ]);

        foreach (['DP' => $o6Dp, 'PEL' => $o6Sisa] as $type => $amount) {
            $inv = Invoice::create([
                'order_id'       => $order6->id,
                'user_id'        => $users['dewi']->id,
                'invoice_number' => "INV-2025-0006-{$type}",
                'amount'         => $amount,
                'status'         => 'paid',
                'due_date'       => now()->subDays($type === 'DP' ? 80 : 25)->toDateString(),
                'paid_at'        => now()->subDays($type === 'DP' ? 85 : 22),
                'created_at'     => now()->subMonths($type === 'DP' ? 3 : 1),
            ]);
            Payment::create([
                'invoice_id' => $inv->id,
                'user_id'    => $users['dewi']->id,
                'amount'     => $amount,
                'method'     => 'transfer',
                'proof_file' => 'payments/dewi_' . strtolower($type) . '.jpg',
                'status'     => 'verified',
                'created_at' => now()->subDays($type === 'DP' ? 85 : 22),
            ]);
        }

        // ── ORDER 7: Indah – Foundation – IN_PROGRESS ────────────────────
        $p7 = $getProduct('Foundation') ?? Product::skip(6)->first();
        $selectedMat7 = [];
        if ($collagen) $selectedMat7[] = ['material_id' => $collagen->id, 'dose_ml' => 0.5];

        $o7LegalCost = 5250000;
        $o7Base = 3500000; $o7Mat = 800000; $o7Pkg = 600000; $o7Des = 750000;
        $o7Sub  = $o7Base + $o7Mat + $o7Pkg + $o7Des;
        $o7Ppn  = ($o7Sub + $o7LegalCost) * 0.11;
        $o7Total = $o7Sub + $o7LegalCost + $o7Ppn;
        $o7Dp    = $o7LegalCost + ($o7Sub * 0.5);
        $o7Sisa  = $o7Sub * 0.5;

        $order7 = Order::create([
            'user_id'           => $users['indah']->id,
            'order_number'      => 'MKL-2026-0007',
            'product_name'      => 'Foundation Cushion SPF50',
            'product_type'      => 'foundation',
            'quantity'          => 300,
            'status'            => 'in_progress',
            'brand_type'        => 'haki',
            'brand_name'        => 'GlowUp Cosmetics',
            'include_bpom'      => true,
            'include_halal'     => true,
            'include_logo'      => true,
            'include_haki'      => true,
            'product_id'        => $p7?->id,
            'volume_ml'         => 15,
            'selected_materials'=> json_encode($selectedMat7),
            'packaging_type_id' => $sachet?->id,
            'design_option'     => 'jasa_desain',
            'legal_cost'        => $o7LegalCost,
            'base_cost'         => $o7Base,
            'material_cost'     => $o7Mat,
            'packaging_cost'    => $o7Pkg,
            'design_cost'       => $o7Des,
            'ppn'               => $o7Ppn,
            'total_amount'      => $o7Total,
            'dp_amount'         => $o7Dp,
            'remaining_amount'  => $o7Sisa,
            'production_status' => 'mixing',
            'current_step'      => 6,
            'mou_status'        => 'approved',
            'confirmed_at'      => now()->subDays(15),
            'created_at'        => now()->subDays(20),
        ]);

        MouDocument::create([
            'order_id'    => $order7->id,
            'status'      => 'approved',
            'reviewed_by' => $adminUser?->id,
            'reviewed_at' => now()->subDays(17),
            'created_at'  => now()->subDays(19),
        ]);

        $inv7dp = Invoice::create([
            'order_id'       => $order7->id,
            'user_id'        => $users['indah']->id,
            'invoice_number' => 'INV-2026-0007-DP',
            'amount'         => $o7Dp,
            'status'         => 'paid',
            'due_date'       => now()->subDays(12)->toDateString(),
            'paid_at'        => now()->subDays(14),
            'created_at'     => now()->subDays(18),
        ]);
        Payment::create([
            'invoice_id' => $inv7dp->id,
            'user_id'    => $users['indah']->id,
            'amount'     => $o7Dp,
            'method'     => 'transfer',
            'proof_file' => 'payments/indah_dp_007.jpg',
            'status'     => 'verified',
            'created_at' => now()->subDays(14),
        ]);

        // ── ORDER 8: Budi – Draft (wizard step 2) ────────────────────────
        Order::create([
            'user_id'      => $users['budi']->id,
            'order_number' => 'MKL-2026-0008',
            'product_name' => 'Order Baru',
            'quantity'     => 0,
            'status'       => 'draft',
            'brand_type'   => 'haki',
            'include_bpom' => true,
            'current_step' => 2,
            'mou_status'   => 'draft',
            'created_at'   => now()->subHours(3),
        ]);

        // ── ORDER 9: Maya – Pending (baru submit) ────────────────────────
        $p9 = $getProduct('Body Scrub') ?? Product::skip(7)->first();
        $o9LegalCost = 1250000;
        $o9Base = 1500000; $o9Pkg = 250000;
        $o9Sub  = $o9Base + $o9Pkg;
        $o9Ppn  = ($o9Sub + $o9LegalCost) * 0.11;
        $o9Total = $o9Sub + $o9LegalCost + $o9Ppn;
        $o9Dp    = $o9LegalCost + ($o9Sub * 0.5);

        $order9 = Order::create([
            'user_id'           => $users['maya']->id,
            'order_number'      => 'MKL-2026-0009',
            'product_name'      => 'Body Scrub Coffee 200ml',
            'product_type'      => 'body_scrub',
            'quantity'          => 100,
            'status'            => 'pending',
            'brand_type'        => 'undername',
            'brand_name'        => 'Beauty Lab',
            'include_bpom'      => true,
            'product_id'        => $p9?->id,
            'volume_ml'         => 200,
            'packaging_type_id' => $jarMed?->id,
            'design_option'     => 'none',
            'legal_cost'        => $o9LegalCost,
            'base_cost'         => $o9Base,
            'packaging_cost'    => $o9Pkg,
            'ppn'               => $o9Ppn,
            'total_amount'      => $o9Total,
            'dp_amount'         => $o9Dp,
            'remaining_amount'  => $o9Sub * 0.5,
            'current_step'      => 6,
            'mou_status'        => 'waiting',
            'created_at'        => now()->subHours(6),
        ]);

        MouDocument::create([
            'order_id'   => $order9->id,
            'status'     => 'signed_uploaded',
            'signed_pdf' => 'mou/mou_order9_signed.pdf',
            'created_at' => now()->subHours(2),
        ]);
    }
}
