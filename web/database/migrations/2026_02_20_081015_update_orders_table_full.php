<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = [
        'brand_type', 'brand_name', 'include_bpom', 'include_halal',
        'include_logo', 'include_haki', 'product_id', 'volume_ml',
        'selected_materials', 'packaging_type_id',
        'design_option', 'design_file_url', 'design_description',
        'request_sample', 'legal_cost', 'base_cost', 'material_cost',
        'packaging_cost', 'design_cost', 'sample_cost', 'ppn',
        'total_amount', 'dp_amount', 'remaining_amount',
        'production_status', 'tracking_number', 'courier',
        'current_step', 'mou_status',
    ];

    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'brand_type')) {
                $table->string('brand_type')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'brand_name')) {
                $table->string('brand_name')->nullable()->after('brand_type');
            }
            if (!Schema::hasColumn('orders', 'include_bpom')) {
                $table->boolean('include_bpom')->default(true)->after('brand_name');
            }
            if (!Schema::hasColumn('orders', 'include_halal')) {
                $table->boolean('include_halal')->default(false)->after('include_bpom');
            }
            if (!Schema::hasColumn('orders', 'include_logo')) {
                $table->boolean('include_logo')->default(false)->after('include_halal');
            }
            if (!Schema::hasColumn('orders', 'include_haki')) {
                $table->boolean('include_haki')->default(false)->after('include_logo');
            }
            if (!Schema::hasColumn('orders', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete()->after('include_haki');
            }
            if (!Schema::hasColumn('orders', 'volume_ml')) {
                $table->integer('volume_ml')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('orders', 'selected_materials')) {
                $table->json('selected_materials')->nullable()->after('volume_ml');
            }
            if (!Schema::hasColumn('orders', 'packaging_type_id')) {
                $table->foreignId('packaging_type_id')->nullable()->constrained('packaging_types')->nullOnDelete()->after('selected_materials');
            }
            // quantity already exists from create_orders_table - skip
            if (!Schema::hasColumn('orders', 'design_option')) {
                $table->string('design_option')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('orders', 'design_file_url')) {
                $table->string('design_file_url')->nullable()->after('design_option');
            }
            if (!Schema::hasColumn('orders', 'design_description')) {
                $table->text('design_description')->nullable()->after('design_file_url');
            }
            if (!Schema::hasColumn('orders', 'request_sample')) {
                $table->boolean('request_sample')->default(false)->after('design_description');
            }
            if (!Schema::hasColumn('orders', 'legal_cost')) {
                $table->decimal('legal_cost', 15, 2)->default(0)->after('request_sample');
            }
            if (!Schema::hasColumn('orders', 'base_cost')) {
                $table->decimal('base_cost', 15, 2)->default(0)->after('legal_cost');
            }
            if (!Schema::hasColumn('orders', 'material_cost')) {
                $table->decimal('material_cost', 15, 2)->default(0)->after('base_cost');
            }
            if (!Schema::hasColumn('orders', 'packaging_cost')) {
                $table->decimal('packaging_cost', 15, 2)->default(0)->after('material_cost');
            }
            if (!Schema::hasColumn('orders', 'design_cost')) {
                $table->decimal('design_cost', 15, 2)->default(0)->after('packaging_cost');
            }
            if (!Schema::hasColumn('orders', 'sample_cost')) {
                $table->decimal('sample_cost', 15, 2)->default(0)->after('design_cost');
            }
            if (!Schema::hasColumn('orders', 'ppn')) {
                $table->decimal('ppn', 15, 2)->default(0)->after('sample_cost');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->default(0)->after('ppn');
            }
            if (!Schema::hasColumn('orders', 'dp_amount')) {
                $table->decimal('dp_amount', 15, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('orders', 'remaining_amount')) {
                $table->decimal('remaining_amount', 15, 2)->default(0)->after('dp_amount');
            }
            if (!Schema::hasColumn('orders', 'production_status')) {
                $table->string('production_status')->nullable()->after('remaining_amount');
            }
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('production_status');
            }
            if (!Schema::hasColumn('orders', 'courier')) {
                $table->string('courier')->nullable()->after('tracking_number');
            }
            if (!Schema::hasColumn('orders', 'current_step')) {
                $table->integer('current_step')->default(1)->after('courier');
            }
            if (!Schema::hasColumn('orders', 'mou_status')) {
                $table->string('mou_status')->default('draft')->after('current_step');
            }
        });
    }

    public function down(): void
    {
        $existing = array_filter($this->columns, fn($col) => Schema::hasColumn('orders', $col));
        if (!empty($existing)) {
            Schema::table('orders', function (Blueprint $table) use ($existing) {
                $table->dropColumn(array_values($existing));
            });
        }
    }
};
