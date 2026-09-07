<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Line items for an order. product_id / variant_id are nullable so the row
 * survives catalog deletions; item_name / variant_label / unit_price are
 * snapshots taken at order time. quantity must be > 0 (validation).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignUuid('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignUuid('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->text('item_name');
            $table->text('variant_label')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->string('currency')->default('INR');
            $table->timestampTz('created_at')->nullable()->useCurrent();

            $table->index('order_id');
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
