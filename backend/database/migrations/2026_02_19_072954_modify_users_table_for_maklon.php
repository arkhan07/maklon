<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('business_type')->nullable()->after('phone');
            $table->string('google_id')->nullable()->unique()->after('business_type');
            $table->string('avatar')->nullable()->after('google_id');
            $table->enum('role', [
                'customer',
                'super_admin',
                'admin_verifikasi',
                'admin_produksi',
                'admin_keuangan',
            ])->default('customer')->after('avatar');
            $table->boolean('is_active')->default(true)->after('role');
            $table->enum('verification_status', [
                'unverified',
                'pending',
                'approved',
                'rejected',
            ])->default('unverified')->after('is_active');
            $table->text('verification_notes')->nullable()->after('verification_status');
            $table->timestamp('last_login_at')->nullable()->after('verification_notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'business_type', 'google_id', 'avatar',
                'role', 'is_active', 'verification_status',
                'verification_notes', 'last_login_at',
            ]);
        });
    }
};
