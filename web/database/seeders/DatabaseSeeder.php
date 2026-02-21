<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@maklon.id'],
            [
                'name'                => 'Super Admin',
                'email'               => 'superadmin@maklon.id',
                'password'            => Hash::make('superadmin123'),
                'role'                => 'super_admin',
                'is_active'           => true,
                'email_verified_at'   => now(),
                'verification_status' => 'verified',
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@maklon.id'],
            [
                'name'                => 'Admin Maklon',
                'email'               => 'admin@maklon.id',
                'password'            => Hash::make('admin123'),
                'role'                => 'admin',
                'is_active'           => true,
                'email_verified_at'   => now(),
                'verification_status' => 'verified',
            ]
        );

        // User Terverifikasi
        User::updateOrCreate(
            ['email' => 'user@maklon.id'],
            [
                'name'                => 'Budi Santoso',
                'email'               => 'user@maklon.id',
                'password'            => Hash::make('user123'),
                'phone'               => '081234567890',
                'company_name'        => 'PT Kosmetik Nusantara',
                'role'                => 'user',
                'is_active'           => true,
                'email_verified_at'   => now(),
                'verification_status' => 'verified',
                'verified_at'         => now(),
                'business_type'       => 'PT',
                'npwp'                => '12.345.678.9-012.000',
                'address'             => 'Jl. Sudirman No. 10, Jakarta Selatan',
            ]
        );

        // User Belum Terverifikasi
        User::updateOrCreate(
            ['email' => 'newuser@maklon.id'],
            [
                'name'                => 'Siti Rahayu',
                'email'               => 'newuser@maklon.id',
                'password'            => Hash::make('user123'),
                'phone'               => '082198765432',
                'company_name'        => 'CV Beauty Alami',
                'role'                => 'user',
                'is_active'           => true,
                'email_verified_at'   => now(),
                'verification_status' => 'unverified',
            ]
        );

        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            MaterialSeeder::class,
        ]);
    }
}
