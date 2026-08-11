<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ARCHITECTURAL MIGRATION: Move content fields from projects to campaigns.
     * Projects become lightweight brand wrappers (name + social accounts).
     * Campaigns become the content-rich entities (description, audience, tone, etc.).
     */
    public function up(): void
    {
        // Step 1: Add content fields to campaigns table
        Schema::table('campaigns', function (Blueprint $table) {
            $table->text('description')->nullable()->after('status');
            $table->string('target_audience')->nullable()->after('description');
            $table->text('value_proposition')->nullable()->after('target_audience');
            $table->string('tone_of_voice')->nullable()->after('value_proposition');
            $table->string('language')->default('English')->after('tone_of_voice');
            $table->json('platforms')->nullable()->after('language');
        });

        // Step 2: Copy existing data from projects to their campaigns
        $projects = DB::table('projects')->get();
        foreach ($projects as $project) {
            DB::table('campaigns')
                ->where('project_id', $project->id)
                ->update([
                    'description' => $project->description,
                    'target_audience' => $project->target_audience,
                    'value_proposition' => $project->value_proposition,
                    'tone_of_voice' => $project->tone_of_voice,
                    'language' => $project->language ?? 'English',
                    'platforms' => $project->platforms,
                ]);
        }

        // Step 3: Remove content fields from projects table (keep only name + user_id)
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'target_audience',
                'value_proposition',
                'tone_of_voice',
                'language',
                'website_url',
                'platforms',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore fields to projects
        Schema::table('projects', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('target_audience')->nullable();
            $table->text('value_proposition')->nullable();
            $table->string('tone_of_voice')->nullable();
            $table->string('language')->default('English');
            $table->string('website_url')->nullable();
            $table->json('platforms')->nullable();
        });

        // Remove fields from campaigns
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'target_audience',
                'value_proposition',
                'tone_of_voice',
                'language',
                'platforms',
            ]);
        });
    }
};
