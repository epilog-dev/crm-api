<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Store catalog products. `status` is 'active' | 'archived'.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->text('title');
            $table->text('description')->nullable();
            $table->decimal('base_price', 12, 2)->nullable();
            $table->string('currency')->default('INR');
            $table->string('status')->default('active');
            $table->text('image_url')->nullable();
            $table->text('instagram_post_id')->nullable();
            $table->text('instagram_link')->nullable();
            $table->jsonb('attributes')->default('{}');
            $table->timestampsTz();

            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
