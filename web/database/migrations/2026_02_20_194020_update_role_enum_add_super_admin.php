<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user','admin','super_admin') NOT NULL DEFAULT 'user'");
        }

        if ($driver === 'sqlite') {
            // SQLite stores enums as TEXT + CHECK constraint.
            // Rebuild the table to drop the old check constraint and allow super_admin.
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::statement('CREATE TABLE users_role_fix AS SELECT * FROM users');
            DB::statement('DROP TABLE users');
            DB::statement("
                CREATE TABLE users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT NOT NULL UNIQUE,
                    email_verified_at TEXT,
                    password TEXT NOT NULL,
                    phone TEXT,
                    company_name TEXT,
                    google_id TEXT,
                    avatar TEXT,
                    is_active INTEGER NOT NULL DEFAULT 1,
                    role TEXT NOT NULL DEFAULT 'user',
                    verification_status TEXT NOT NULL DEFAULT 'unverified',
                    verification_notes TEXT,
                    verified_at TEXT,
                    business_type TEXT,
                    npwp TEXT,
                    address TEXT,
                    legal_option TEXT,
                    legal_package_type TEXT,
                    remember_token TEXT,
                    created_at TEXT,
                    updated_at TEXT
                )
            ");
            DB::statement('INSERT INTO users SELECT id, name, email, email_verified_at, password, phone, company_name, google_id, avatar, is_active, role, verification_status, verification_notes, verified_at, business_type, npwp, address, legal_option, legal_package_type, remember_token, created_at, updated_at FROM users_role_fix');
            DB::statement('DROP TABLE users_role_fix');
            DB::statement('PRAGMA foreign_keys = ON');
        }
    }

    public function down(): void
    {
        //
    }
};
