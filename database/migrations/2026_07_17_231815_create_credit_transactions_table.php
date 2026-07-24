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
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // e.g. 'purchase', 'consumption', 'technical_refund'
            $table->string('type'); 
            
            // Positive for credit, negative for debit
            $table->integer('amount'); 
            
            // To easily query balance at that point in time (optional but good for history)
            $table->integer('balance_after')->default(0);

            // Context of the transaction
            $table->string('description');
            
            // The idempotency key to prevent double charging/refunding
            $table->string('idempotency_key')->unique(); 
            
            // Optional links to what caused this
            $table->string('reference_type')->nullable(); // e.g. App\Models\Campaign
            $table->unsignedBigInteger('reference_id')->nullable(); 
            
            // Extra metadata if needed (e.g. Stripe payment ID)
            $table->json('metadata')->nullable();

            $table->timestamps();
            
            // Indexes for fast balance calculation
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_transactions');
    }
};
