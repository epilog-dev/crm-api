<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The tenant root. One row per seller account.
 *
 * Ported from the Supabase `crm` project schema (DATABASE_DESIGN.md).
 * Supabase-only concerns handled in the application layer instead:
 *  - RLS / is_store_member() gating -> API middleware & policies.
 *  - handle_new_store() trigger (auto-add owner membership) -> Store observer.
 *  - set_updated_at() trigger -> Eloquent timestamps().
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name');
            $table->text('instagram_handle')->nullable();
            $table->text('instagram_business_id')->nullable()->unique();
            $table->text('instagram_username')->nullable();
            $table->text('instagram_avatar_url')->nullable();
            $table->integer('instagram_followers_count')->nullable();
            $table->boolean('instagram_connected')->default(false);
            $table->timestampTz('instagram_connected_at')->nullable();
            $table->text('webhook_status')->nullable();
            $table->text('upi_vpa')->nullable();
            $table->boolean('cod_enabled')->default(false);
            $table->boolean('require_receipt_upload')->default(true);
            $table->boolean('auto_link_dms')->default(true);
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
