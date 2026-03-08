<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // INV-2026-00001 (immutable)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->enum('status', ['draft', 'issued', 'voided'])->default('draft');

            // Snapshots at time of generation
            $table->json('client_snapshot')->nullable();
            $table->json('financial_snapshot')->nullable(); // items, totals, shipping

            // Issue
            $table->timestamp('issued_at')->nullable();

            // Void
            $table->timestamp('voided_at')->nullable();
            $table->foreignId('voided_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('void_reason')->nullable();

            // PDF storage
            $table->string('pdf_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
