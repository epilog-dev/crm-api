<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Landing free-text suggestions. INSERT-only for the public (enforce in the
 * controller). `message` length 1..2000 and optional `email` are validated
 * in the form request (were Postgres CHECK constraints).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('message');
            $table->text('email')->nullable();
            $table->timestampTz('created_at')->nullable()->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
