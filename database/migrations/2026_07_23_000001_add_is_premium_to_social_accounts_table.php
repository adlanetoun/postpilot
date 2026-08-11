<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('social_accounts', 'is_premium')) {
            Schema::table('social_accounts', function (Blueprint $table) {
                $table->boolean('is_premium')->nullable()->after('access_token');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('social_accounts', 'is_premium')) {
            Schema::table('social_accounts', function (Blueprint $table) {
                $table->dropColumn('is_premium');
            });
        }
    }
};
