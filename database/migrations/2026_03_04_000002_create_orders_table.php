<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ORD-2026-00001
            $table->enum('type', ['inquiry', 'order'])->default('inquiry');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            // Status workflow
            $table->enum('status', [
                'unprocessed',
                'quotation_sent',
                'processed',
                'dispatched',
                'delivered',
                'cancelled'
            ])->default('unprocessed');

            // Financial fields
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('item_discount_total', 12, 2)->default(0);
            $table->enum('order_discount_type', ['percent', 'fixed', 'none'])->default('none');
            $table->decimal('order_discount_value', 12, 2)->default(0);
            $table->decimal('order_discount_amount', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total_weight_kg', 10, 3)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            // Financial lock (set when marked as paid)
            $table->boolean('is_paid')->default(false);
            $table->timestamp('financial_locked_at')->nullable();

            // Shipping / dispatch
            $table->foreignId('shipping_provider_id')->nullable()->constrained('shipping_providers')->onDelete('set null');
            $table->string('tracking_number')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('expected_delivery_at')->nullable();
            $table->unsignedSmallInteger('delivery_period_days')->default(14);

            // Client snapshot (JSON copy at order finalization)
            $table->json('client_snapshot')->nullable();

            // Merge support
            $table->foreignId('merged_into_order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->boolean('is_merged')->default(false);
            $table->json('merged_order_ids')->nullable(); // Array of child order IDs merged into this

            // Meta
            $table->text('notes')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('cancellation_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
