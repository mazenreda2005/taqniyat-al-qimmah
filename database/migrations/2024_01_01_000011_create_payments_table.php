<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for payments/transactions table
 * Stores detailed payment information for each transaction
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('payment_method', [
                'visa_mada',
                'stc_pay',
                'tamara',
                'bank_transfer',
                'cash_on_delivery'
            ]);
            
            // Payment status
            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'under_review',
                'refunded',
                'cancelled'
            ])->default('pending');
            
            // Amount details
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('SAR');
            
            // Transaction IDs from payment gateways
            $table->string('transaction_id')->nullable()->unique();
            $table->string('reference_number')->nullable();
            
            // For bank transfer: receipt upload
            $table->string('receipt_path')->nullable();
            
            // Payment gateway response (JSON)
            $table->json('gateway_response')->nullable();
            
            // Webhook data (JSON)
            $table->json('webhook_data')->nullable();
            
            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
