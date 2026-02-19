<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'Maklon.id', 'type' => 'string', 'description' => 'Nama aplikasi'],
            ['key' => 'app_tagline', 'value' => 'Jasa Maklon Kosmetik Profesional', 'type' => 'string', 'description' => 'Tagline aplikasi'],
            ['key' => 'ppn_rate', 'value' => '11', 'type' => 'integer', 'description' => 'PPN rate dalam persen'],
            ['key' => 'min_order_qty', 'value' => '100', 'type' => 'integer', 'description' => 'Minimum order quantity (pcs)'],
            ['key' => 'dp_percentage', 'value' => '50', 'type' => 'integer', 'description' => 'Persentase DP dari total produk'],
            ['key' => 'bpom_price', 'value' => '1250000', 'type' => 'integer', 'description' => 'Harga izin edar BPOM'],
            ['key' => 'halal_price', 'value' => '2500000', 'type' => 'integer', 'description' => 'Harga sertifikasi halal'],
            ['key' => 'haki_logo_price', 'value' => '1500000', 'type' => 'integer', 'description' => 'Harga pembuatan logo dan cek merek HAKI'],
            ['key' => 'haki_djki_price', 'value' => '2750000', 'type' => 'integer', 'description' => 'Harga pendaftaran merek DJKI per kelas'],
            ['key' => 'pt_perorangan_price', 'value' => '1500000', 'type' => 'integer', 'description' => 'Harga paket pendirian PT Perorangan'],
            ['key' => 'pt_perseroan_price', 'value' => '5000000', 'type' => 'integer', 'description' => 'Harga paket pendirian PT Perseroan'],
            ['key' => 'design_service_price', 'value' => '750000', 'type' => 'integer', 'description' => 'Harga jasa desain sticker packaging'],
            ['key' => 'sample_price', 'value' => '500000', 'type' => 'integer', 'description' => 'Harga request sample per produk'],
            ['key' => 'sample_max_revisions', 'value' => '2', 'type' => 'integer', 'description' => 'Maksimal revisi sample'],
            ['key' => 'sample_turnaround_days', 'value' => '7', 'type' => 'integer', 'description' => 'Estimasi hari kerja pembuatan sample'],
            ['key' => 'legality_verification_days', 'value' => '3', 'type' => 'integer', 'description' => 'Estimasi hari kerja verifikasi legalitas'],
            ['key' => 'mou_payment_deadline_days', 'value' => '7', 'type' => 'integer', 'description' => 'Tenggat waktu pembayaran DP setelah MOU diapprove (hari)'],
            ['key' => 'company_name', 'value' => 'PT Maklon Indonesia', 'type' => 'string', 'description' => 'Nama resmi perusahaan'],
            ['key' => 'company_address', 'value' => 'Jakarta, Indonesia', 'type' => 'string', 'description' => 'Alamat perusahaan'],
            ['key' => 'company_email', 'value' => 'info@maklon.id', 'type' => 'string', 'description' => 'Email perusahaan'],
            ['key' => 'company_phone', 'value' => '+62 21 xxxx xxxx', 'type' => 'string', 'description' => 'No telepon perusahaan'],
            ['key' => 'bank_name', 'value' => 'BCA', 'type' => 'string', 'description' => 'Nama bank untuk transfer'],
            ['key' => 'bank_account', 'value' => '1234567890', 'type' => 'string', 'description' => 'Nomor rekening bank'],
            ['key' => 'bank_holder', 'value' => 'PT Maklon Indonesia', 'type' => 'string', 'description' => 'Nama pemilik rekening'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
