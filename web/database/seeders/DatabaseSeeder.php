<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@maklon.id'],
            [
                'name'     => 'Admin Maklon',
                'email'    => 'admin@maklon.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'is_active' => true,
            ]
        );

        // Demo User
        User::updateOrCreate(
            ['email' => 'demo@maklon.id'],
            [
                'name'         => 'Demo Customer',
                'email'        => 'demo@maklon.id',
                'password'     => Hash::make('demo123'),
                'phone'        => '081234567890',
                'company_name' => 'PT Demo Kosmetik',
                'role'         => 'user',
                'is_active'    => true,
            ]
        );
    }
}
