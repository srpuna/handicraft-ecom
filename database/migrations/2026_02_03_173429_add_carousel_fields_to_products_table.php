<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Carousel/Collection flags
            $table->boolean('is_new_arrival')->default(false)->after('is_order_now_enabled');
            $table->boolean('is_featured')->default(false)->after('is_new_arrival');
            $table->boolean('is_recommended')->default(false)->after('is_featured');
            $table->boolean('is_on_sale')->default(false)->after('is_recommended');
            
            // Priority for ordering in carousels (lower = higher priority)
            $table->integer('carousel_priority')->default(0)->after('is_on_sale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_new_arrival',
                'is_featured',
                'is_recommended',
                'is_on_sale',
                'carousel_priority'
            ]);
        });
    }
};
