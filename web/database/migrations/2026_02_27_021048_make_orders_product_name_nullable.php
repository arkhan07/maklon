<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite: no MODIFY COLUMN — use raw statement only on MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN product_name VARCHAR(255) NULL DEFAULT NULL");
            DB::statement("ALTER TABLE orders MODIFY COLUMN quantity INT NULL DEFAULT NULL");
        }
        // SQLite already accepts nullable by default (no strict enforcement)
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN product_name VARCHAR(255) NOT NULL");
            DB::statement("ALTER TABLE orders MODIFY COLUMN quantity INT NOT NULL");
        }
    }
};
