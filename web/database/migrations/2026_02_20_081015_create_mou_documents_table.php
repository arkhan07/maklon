<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mou_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('generated_pdf')->nullable(); // auto-generated MOU path
            $table->string('signed_pdf')->nullable(); // customer uploaded signed MOU
            $table->enum('status', ['draft', 'waiting_signature', 'signed_uploaded', 'approved', 'rejected'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mou_documents');
    }
};
