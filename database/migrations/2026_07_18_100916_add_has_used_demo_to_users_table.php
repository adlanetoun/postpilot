<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_used_demo')->default(false)->after('campaign_credits')
                ->comment('True after the user has generated their one free preview campaign — they must buy credits for future generations');
            $table->index('has_used_demo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['has_used_demo']);
            $table->dropColumn('has_used_demo');
        });
    }
};
