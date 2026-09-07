<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * In-app notification feed per store.
 *
 * Enforced in validation (were Postgres CHECK constraints):
 *  - type        in order | payment | dm | system
 *  - badge_color in primary | success | warning | info | error | neutral
 *
 * The source schema also has a partial index on (store_id) WHERE NOT read;
 * Laravel's schema builder can't express a partial index portably, so this
 * uses a plain composite index instead.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('type');
            $table->text('title');
            $table->text('message');
            $table->text('link')->nullable();
            $table->string('icon')->default('i-lucide-bell');
            $table->string('badge_color')->default('primary');
            $table->boolean('read')->default(false);
            $table->foreignUuid('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->foreignUuid('conversation_id')->nullable()->constrained('conversations')->nullOnDelete();
            $table->timestampTz('created_at')->nullable()->useCurrent();

            $table->index(['store_id', 'created_at']);
            $table->index(['store_id', 'read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
