<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Landing feature-vote capture. INSERT-only for the public (enforce in the
 * controller).
 *
 * `feature_key` (was a Postgres CHECK) in:
 *   courier_tracking | auto_payment_check | team_inbox | whatsapp_inbox | repeat_buyer_insights
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_votes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('feature_key');
            $table->timestampTz('created_at')->nullable()->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_votes');
    }
};
