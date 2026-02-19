<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@maklon.id',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'phone' => '081234567890',
                'business_type' => 'Admin',
                'verification_status' => 'approved',
                'is_active' => true,
            ],
            [
                'name' => 'Admin Verifikasi',
                'email' => 'admin.verifikasi@maklon.id',
                'password' => Hash::make('password123'),
                'role' => 'admin_verifikasi',
                'phone' => '081234567891',
                'business_type' => 'Admin',
                'verification_status' => 'approved',
                'is_active' => true,
            ],
            [
                'name' => 'Admin Produksi',
                'email' => 'admin.produksi@maklon.id',
                'password' => Hash::make('password123'),
                'role' => 'admin_produksi',
                'phone' => '081234567892',
                'business_type' => 'Admin',
                'verification_status' => 'approved',
                'is_active' => true,
            ],
            [
                'name' => 'Admin Keuangan',
                'email' => 'admin.keuangan@maklon.id',
                'password' => Hash::make('password123'),
                'role' => 'admin_keuangan',
                'phone' => '081234567893',
                'business_type' => 'Admin',
                'verification_status' => 'approved',
                'is_active' => true,
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(['email' => $admin['email']], $admin);
        }
    }
}
