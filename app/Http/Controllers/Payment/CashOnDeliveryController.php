<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Cash on Delivery Payment Controller
 * Handles cash on delivery orders
 */
class CashOnDeliveryController extends Controller
{
    /**
     * Confirm cash on delivery order
     */
    public function confirm(Order $order)
    {
        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'cash_on_delivery',
            'status' => 'pending',
            'amount' => $order->total_amount,
            'currency' => 'SAR',
        ]);

        // Update order
        $order->update([
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
            'status' => 'processing', // Order is confirmed, payment on delivery
        ]);

        return redirect()->route('payment.success', $order)
            ->with('success', __('Order confirmed! Payment will be collected on delivery.'))
            ->with('payment_completed_message', __('The operation has been completed successfully.'));
    }
}
