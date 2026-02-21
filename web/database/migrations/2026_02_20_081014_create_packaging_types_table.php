<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packaging_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Botol Pump, Jar, Spray, etc.
            $table->string('type'); // bottle, jar, spray, tube, etc.
            $table->decimal('price', 15, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packaging_types');
    }
};
