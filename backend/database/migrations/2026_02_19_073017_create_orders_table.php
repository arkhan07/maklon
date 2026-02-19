<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'draft',
                'submitted',
                'mou_pending',
                'mou_approved',
                'dp_pending',
                'dp_confirmed',
                'sample_process',
                'sample_approved',
                'production',
                'qc',
                'packing',
                'ready_to_ship',
                'shipped',
                'completed',
                'cancelled',
            ])->default('draft');

            // Step 1: Brand & Legal
            $table->enum('brand_type', ['haki', 'undername'])->nullable();
            $table->string('brand_name')->nullable();
            $table->string('brand_logo_url')->nullable();
            $table->text('brand_description')->nullable();
            $table->text('brand_visual_description')->nullable();
            $table->string('brand_name_translation')->nullable();

            // Legal add-ons flags
            $table->boolean('include_bpom')->default(true); // mandatory
            $table->boolean('include_halal')->default(false);
            $table->boolean('include_haki_logo')->default(false);
            $table->boolean('include_haki_djki')->default(false);

            // Step 2: Product
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('volume_ml')->nullable();
            $table->integer('quantity')->nullable();

            // Step 3: Materials -> order_materials pivot

            // Step 4: Packaging
            $table->foreignId('packaging_option_id')->nullable()->constrained()->nullOnDelete();

            // Step 5: Design
            $table->enum('design_type', ['jasa_design', 'own_design', 'none'])->default('none');
            $table->string('design_file_url')->nullable();
            $table->text('design_description')->nullable();
            $table->decimal('design_price', 15, 2)->default(0);

            // Step 5.5: Sample
            $table->boolean('sample_requested')->default(false);
            $table->decimal('sample_price', 15, 2)->default(0);
            $table->tinyInteger('sample_revisions_used')->default(0);
            $table->enum('sample_status', ['none', 'pending', 'in_progress', 'approved', 'rejected'])->default('none');

            // Pricing summary
            $table->decimal('subtotal_legal', 15, 2)->default(0);
            $table->decimal('subtotal_product', 15, 2)->default(0);
            $table->decimal('ppn_rate', 5, 2)->default(11);
            $table->decimal('ppn_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('dp_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->default(0);

            // Shipping
            $table->string('shipping_tracking')->nullable();
            $table->string('shipping_courier')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
