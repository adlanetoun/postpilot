<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('credit_transactions')) {
            return;
        }

        Schema::table('credit_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('credit_transactions', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('metadata');
            }

            if (! Schema::hasColumn('credit_transactions', 'user_agent')) {
                $table->string('user_agent', 512)->nullable()->after('ip_address');
            }

            if (! Schema::hasColumn('credit_transactions', 'flagged_for_review')) {
                $table->boolean('flagged_for_review')->default(false)->after('user_agent');
            }

            if (! Schema::hasColumn('credit_transactions', 'flag_reason')) {
                $table->string('flag_reason')->nullable()->after('flagged_for_review');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('credit_transactions')) {
            return;
        }

        Schema::table('credit_transactions', function (Blueprint $table) {
            foreach (['ip_address', 'user_agent', 'flagged_for_review', 'flag_reason'] as $column) {
                if (Schema::hasColumn('credit_transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
