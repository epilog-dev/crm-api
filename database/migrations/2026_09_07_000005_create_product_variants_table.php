<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-product variants. `store_id` is denormalised for tenant scoping.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->text('label');
            $table->text('sku')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('stock', 12, 2)->default(0);
            $table->jsonb('attributes')->default('{}');
            $table->timestampsTz();

            $table->index('product_id');
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
