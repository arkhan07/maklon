<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Step 1: Legal Brand
            $table->string('brand_type')->nullable()->after('user_id'); // haki, undername
            $table->string('brand_name')->nullable()->after('brand_type');
            $table->boolean('include_bpom')->default(true)->after('brand_name');
            $table->boolean('include_halal')->default(false)->after('include_bpom');
            $table->boolean('include_logo')->default(false)->after('include_halal');
            $table->boolean('include_haki')->default(false)->after('include_logo');

            // Step 2: Product
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete()->after('include_haki');
            $table->integer('volume_ml')->nullable()->after('product_id');

            // Step 3: Materials (JSON array)
            $table->json('selected_materials')->nullable()->after('volume_ml'); // [{material_id, dose_ml}]

            // Step 4: Packaging
            $table->foreignId('packaging_type_id')->nullable()->constrained('packaging_types')->nullOnDelete()->after('selected_materials');
            // quantity column already exists in create_orders_table, skip adding it

            // Step 5: Design & Sample
            $table->string('design_option')->nullable()->after('quantity'); // service, self_upload, none
            $table->string('design_file_url')->nullable()->after('design_option');
            $table->text('design_description')->nullable()->after('design_file_url');
            $table->boolean('request_sample')->default(false)->after('design_description');

            // Pricing
            $table->decimal('legal_cost', 15, 2)->default(0)->after('request_sample');
            $table->decimal('base_cost', 15, 2)->default(0)->after('legal_cost');
            $table->decimal('material_cost', 15, 2)->default(0)->after('base_cost');
            $table->decimal('packaging_cost', 15, 2)->default(0)->after('material_cost');
            $table->decimal('design_cost', 15, 2)->default(0)->after('packaging_cost');
            $table->decimal('sample_cost', 15, 2)->default(0)->after('design_cost');
            $table->decimal('ppn', 15, 2)->default(0)->after('sample_cost');
            $table->decimal('total_amount', 15, 2)->default(0)->after('ppn');
            $table->decimal('dp_amount', 15, 2)->default(0)->after('total_amount');
            $table->decimal('remaining_amount', 15, 2)->default(0)->after('dp_amount');

            // Production tracking
            $table->string('production_status')->nullable()->after('remaining_amount'); // antri, mixing, qc, packing, siap_kirim, terkirim
            $table->string('tracking_number')->nullable()->after('production_status');
            $table->string('courier')->nullable()->after('tracking_number');
            $table->integer('current_step')->default(1)->after('courier'); // order wizard step

            // MOU
            $table->string('mou_status')->default('draft')->after('current_step'); // draft, waiting, signed, approved
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'brand_type', 'brand_name', 'include_bpom', 'include_halal',
                'include_logo', 'include_haki', 'product_id', 'volume_ml',
                'selected_materials', 'packaging_type_id', 'quantity',
                'design_option', 'design_file_url', 'design_description',
                'request_sample', 'legal_cost', 'base_cost', 'material_cost',
                'packaging_cost', 'design_cost', 'sample_cost', 'ppn',
                'total_amount', 'dp_amount', 'remaining_amount',
                'production_status', 'tracking_number', 'courier',
                'current_step', 'mou_status',
            ]);
        });
    }
};
