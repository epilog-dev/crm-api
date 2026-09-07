<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Join table between users and stores; defines role.
 *
 * `user_id` references the local Laravel `users` table (there is no Supabase
 * `auth.users` here). `role` is 'owner' | 'staff' (enforced in validation).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->default('staff');
            $table->timestampTz('created_at')->nullable()->useCurrent();

            $table->unique(['store_id', 'user_id']);
            $table->index('store_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_members');
    }
};
