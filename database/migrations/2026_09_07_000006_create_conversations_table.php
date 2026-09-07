<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One Instagram DM thread per customer per store.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->text('instagram_handle');
            $table->text('instagram_name')->nullable();
            $table->text('avatar_url')->nullable();
            $table->string('platform')->default('instagram');
            $table->text('last_message_preview')->nullable();
            $table->timestampTz('last_message_at')->nullable();
            $table->integer('unread_count')->default(0);
            $table->text('instagram_thread_id')->nullable()->unique();
            $table->timestampsTz();

            $table->unique(['store_id', 'instagram_handle']);
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
