<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Landing pricing-survey responses. INSERT-only for the public (enforce in
 * the controller).
 *
 * Enforced in validation (were Postgres CHECK constraints):
 *  - answer         in yes | maybe | no
 *  - monthly_amount null, or between 0 and 100000
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_validation_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('answer');
            $table->integer('monthly_amount')->nullable();
            $table->timestampTz('created_at')->nullable()->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_validation_responses');
    }
};
