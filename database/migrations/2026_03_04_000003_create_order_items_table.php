<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->json('product_snapshot')->nullable(); // name, sku, weight, price snapshot

            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('weight_kg', 10, 3)->default(0); // per-unit weight (overridable)

            // Per-item discount
            $table->enum('item_discount_type', ['percent', 'fixed', 'none'])->default('none');
            $table->decimal('item_discount_value', 12, 2)->default(0);
            $table->decimal('item_discount_amount', 12, 2)->default(0); // calculated

            $table->decimal('line_total', 12, 2)->default(0); // (unit_price - item_discount_per_unit) * qty

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
