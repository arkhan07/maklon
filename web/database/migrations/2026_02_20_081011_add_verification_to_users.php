<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('unverified')->after('role');
            }
            if (!Schema::hasColumn('users', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verification_notes');
            }
            if (!Schema::hasColumn('users', 'business_type')) {
                $table->string('business_type')->nullable()->after('verified_at');
            }
            if (!Schema::hasColumn('users', 'npwp')) {
                $table->string('npwp')->nullable()->after('business_type');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('npwp');
            }
            if (!Schema::hasColumn('users', 'legal_option')) {
                $table->string('legal_option')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'legal_package_type')) {
                $table->string('legal_package_type')->nullable()->after('legal_option');
            }
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
