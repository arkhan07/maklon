<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite doesn't support MODIFY COLUMN — only run on MySQL/MariaDB
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Fix orders.status ENUM: nilai lama (processing, qc, shipping, done)
        // diganti dengan nilai baru sesuai alur sistem (draft, confirmed, in_progress, completed)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
            'draft',
            'pending',
            'confirmed',
            'in_progress',
            'completed',
            'cancelled'
        ) NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
            'pending',
            'processing',
            'qc',
            'shipping',
            'done',
            'cancelled'
        ) NOT NULL DEFAULT 'pending'");
    }
};
