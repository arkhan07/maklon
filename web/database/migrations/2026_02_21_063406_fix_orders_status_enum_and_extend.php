<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite does not support MODIFY COLUMN or ENUM constraints.
        // Status column already accepts any string. Just add new timestamp columns.
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable();
            }
            if (!Schema::hasColumn('orders', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'confirmed_at')) {
                $table->dropColumn('confirmed_at');
            }
            if (Schema::hasColumn('orders', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }
};
