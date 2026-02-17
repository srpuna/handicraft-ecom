<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->longText('long_description')->nullable();
            $table->integer('min_quantity')->default(1);
            $table->string('material')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('sku')->unique()->nullable();

            // Dimensions in cm
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable(); // Breadth
            $table->decimal('height', 8, 2)->nullable();

            // Weight in kg
            $table->decimal('weight', 8, 3)->nullable();

            $table->string('main_image')->nullable();
            $table->string('secondary_image')->nullable();

            $table->boolean('is_order_now_enabled')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
