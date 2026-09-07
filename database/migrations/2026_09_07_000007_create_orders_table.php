<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Customer orders.
 *
 * `order_code` used a Postgres sequence (`ORD-1`, `ORD-2`, ...) in the source
 * schema. Generate it in the application layer; the column stays unique here.
 *
 * Enforced in validation (were Postgres CHECK constraints):
 *  - status         in Confirmed | Awaiting Payment | Paid | Shipped | Delivered | Cancelled
 *  - payment_status in Pending | Paid
 *  - payment_method in pay_now | cod (nullable)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_code')->unique();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignUuid('conversation_id')->nullable()->constrained('conversations')->nullOnDelete();
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('status')->default('Confirmed');
            $table->string('payment_status')->default('Pending');
            $table->string('payment_method')->nullable();
            $table->string('currency')->default('INR');
            $table->text('customer_name')->nullable();
            $table->text('customer_phone')->nullable();
            $table->text('customer_address')->nullable();
            $table->text('customer_pincode')->nullable();
            $table->boolean('confirmed_by_customer')->default(false);
            $table->text('receipt_url')->nullable();
            $table->boolean('receipt_uploaded')->default(false);
            $table->text('payment_ref')->nullable();
            $table->timestampsTz();

            $table->index('store_id');
            $table->index(['store_id', 'status']);
            $table->index('conversation_id');
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
