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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('product_name');
            $table->string('product_type')->nullable(); // serum, moisturizer, dll
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->string('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
