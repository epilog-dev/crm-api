<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Landing capture form. INSERT-only for the public in Supabase (RLS); enforce
 * that at the route/controller level here.
 *
 * `email` is unique on lower(email) in Postgres; here it is a plain unique
 * column, so normalise to lowercase before insert.
 * `source` is 'hero' | 'early_access' (validation).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waitlist_signups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('email')->unique();
            $table->string('source')->default('early_access');
            $table->timestampTz('created_at')->nullable()->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlist_signups');
    }
};
