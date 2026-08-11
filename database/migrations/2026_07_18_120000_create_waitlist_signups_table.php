<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waitlist_signups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email');
            $table->string('plan_interest')->default('annual');
            $table->string('source')->default('profile_edit');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['email', 'plan_interest']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlist_signups');
    }
};
