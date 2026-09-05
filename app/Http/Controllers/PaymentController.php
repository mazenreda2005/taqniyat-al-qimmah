<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Main Payment Controller
 * Handles payment method selection and common payment operations
 */
class PaymentController extends Controller
{
    /**
     * Show payment selection page (integrated in checkout)
     */
    public function selectMethod(Request $request)
    {
        // This is handled in OrderController@checkout
        return redirect()->route('checkout');
    }

    /**
     * Process payment based on selected method
     */
    public function processPayment(Order $order)
    {
        // Ensure order belongs to user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure payment method is set
        if (!$order->payment_method) {
            return redirect()->route('checkout')
                ->with('error', __('Please select a payment method.'));
        }

        // Route to specific payment handler
        return match($order->payment_method) {
            'visa_mada' => redirect()->route('payment.visa-mada.process', $order),
            'stc_pay' => redirect()->route('payment.stc-pay.process', $order),
            'tamara' => redirect()->route('payment.tamara.process', $order),
            'bank_transfer' => redirect()->route('payment.bank-transfer.show', $order),
            'cash_on_delivery' => redirect()->route('payment.cash-on-delivery.confirm', $order),
            default => redirect()->route('checkout')->with('error', __('Invalid payment method.')),
        };
    }

    /**
     * Upload bank transfer receipt
     */
    public function uploadReceipt(Request $request, Order $order)
    {
        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Ensure order belongs to user
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', __('Unauthorized.'));
        }

        // Ensure payment method is bank transfer
        if ($order->payment_method !== 'bank_transfer') {
            return back()->with('error', __('Invalid payment method.'));
        }

        // Upload receipt
        $receiptPath = $request->file('receipt')->store('receipts', 'public');

        // Create or update payment record
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => 'bank_transfer',
                'status' => 'under_review',
                'amount' => $order->total_amount,
                'currency' => 'SAR',
                'receipt_path' => $receiptPath,
            ]
        );

        // Update order payment status
        $order->update([
            'payment_status' => 'under_review',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', __('Receipt uploaded successfully. Your payment is under review.'));
    }

    /**
     * Show payment success page
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payments.success', compact('order'));
    }

    /**
     * Show payment failure page
     */
    public function failure(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payments.failure', compact('order'));
    }
}
