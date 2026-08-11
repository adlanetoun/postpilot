<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ARCHITECTURAL MIGRATION: Move social accounts to project-level.
     */
    public function up(): void
    {
        // Wipe existing social accounts to start with a clean slate
        DB::table('social_accounts')->truncate();

        Schema::table('social_accounts', function (Blueprint $table) {
            // Drop unique constraint on user_id + provider
            $table->dropUnique(['user_id', 'provider']);

            // Add project_id
            $table->foreignId('project_id')->after('user_id')->constrained()->cascadeOnDelete();

            // Note: keeping user_id as it helps with quick global lookups,
            // but the true owner is the project_id.

            // New constraint: A project can only have one account per provider
            $table->unique(['project_id', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('social_accounts')->truncate();

        Schema::table('social_accounts', function (Blueprint $table) {
            $table->dropUnique(['project_id', 'provider']);
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
            $table->unique(['user_id', 'provider']);
        });
    }
};
