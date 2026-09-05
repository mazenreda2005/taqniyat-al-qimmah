<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to add payment-related fields to orders table
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Payment method: visa_mada, stc_pay, tamara, bank_transfer, cash_on_delivery
            $table->enum('payment_method', [
                'visa_mada',
                'stc_pay',
                'tamara',
                'bank_transfer',
                'cash_on_delivery'
            ])->nullable()->after('status');
            
            // Payment status: pending, paid, failed, under_review, refunded
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'under_review',
                'refunded'
            ])->default('pending')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status']);
        });
    }
};
