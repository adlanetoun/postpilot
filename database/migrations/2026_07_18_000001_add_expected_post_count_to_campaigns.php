<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * REVENUE-LEAK AUDIT — Phase 3 LEAK-3 support migration.
 *
 * Adds `expected_post_count` to `campaigns` so the GenerateCampaignChunkJob
 * failed() handler can decrement it on partial generation failures, and
 * finance/audit queries can measure under-delivery vs. credit charged.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Track how many posts the campaign PROMISED to deliver. Decremented
            // when chunks permanently fail so we can detect under-delivery.
            $table->unsignedInteger('expected_post_count')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('expected_post_count');
        });
    }
};
