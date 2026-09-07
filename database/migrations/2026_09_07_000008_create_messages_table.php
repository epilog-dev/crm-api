<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * DM messages within a conversation. `sender` is 'customer' | 'seller'.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('conversation_id')->constrained('conversations')->cascadeOnDelete();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignUuid('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('sender');
            $table->text('body');
            $table->text('instagram_message_id')->nullable()->unique();
            $table->timestampTz('created_at')->nullable()->useCurrent();

            $table->index(['conversation_id', 'created_at']);
            $table->index('order_id');
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
