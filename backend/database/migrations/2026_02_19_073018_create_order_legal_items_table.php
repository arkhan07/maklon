<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_legal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['bpom', 'halal', 'haki_logo', 'haki_djki', 'pt_perorangan', 'pt_perseroan']);
            $table->string('label');
            $table->decimal('amount', 15, 2);
            $table->boolean('is_mandatory')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_legal_items');
    }
};
