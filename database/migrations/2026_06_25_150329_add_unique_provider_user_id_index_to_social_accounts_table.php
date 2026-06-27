<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SECURITY FIX AUDIT-2: Add composite unique index on (provider, provider_user_id).
     * This provides a database-level safety net against duplicate social accounts
     * and eliminates full table scans on the duplicate-check query.
     */
    public function up(): void
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->unique(['provider', 'provider_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->dropUnique(['provider', 'provider_user_id']);
        });
    }
};
