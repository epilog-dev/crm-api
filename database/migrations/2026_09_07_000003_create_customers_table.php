<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * End buyers, scoped per store.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->text('instagram_handle');
            $table->text('name')->nullable();
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('pincode')->nullable();
            $table->text('avatar_url')->nullable();
            $table->timestampsTz();

            $table->unique(['store_id', 'instagram_handle']);
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
