<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified')->after('role');
            $table->text('verification_notes')->nullable()->after('verification_status');
            $table->timestamp('verified_at')->nullable()->after('verification_notes');
            $table->string('business_type')->nullable()->after('verified_at');
            $table->string('npwp')->nullable()->after('business_type');
            $table->text('address')->nullable()->after('npwp');
            $table->enum('legal_option', ['upload', 'buy_package'])->nullable()->after('address');
            $table->string('legal_package_type')->nullable()->after('legal_option');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status', 'verification_notes', 'verified_at',
                'business_type', 'npwp', 'address', 'legal_option', 'legal_package_type',
            ]);
        });
    }
};
