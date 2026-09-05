<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Bank Transfer Payment Controller
 * Handles bank transfer payments with receipt upload
 */
class BankTransferController extends Controller
{
    /**
     * Show bank transfer instructions
     */
    public function show(Order $order)
    {
        // Create payment record if not exists
        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => 'bank_transfer',
                'status' => 'under_review',
                'amount' => $order->total_amount,
                'currency' => 'SAR',
            ]
        );

        // Update order
        $order->update([
            'payment_method' => 'bank_transfer',
            'payment_status' => 'under_review',
        ]);

        // Bank account details from config
        $bankDetails = [
            'bank_name' => config('payment.bank.name'),
            'account_name' => config('payment.bank.account_name'),
            'iban' => config('payment.bank.iban'),
            'account_number' => config('payment.bank.account_number'),
        ];

        return view('payments.bank-transfer', compact('order', 'bankDetails', 'payment'));
    }

    /**
     * Upload receipt (handled by main PaymentController)
     */
    // This is handled in PaymentController@uploadReceipt
}
