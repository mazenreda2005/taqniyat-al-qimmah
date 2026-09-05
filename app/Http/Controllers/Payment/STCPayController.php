<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * STC Pay Payment Controller
 * Handles STC Pay mobile payment integration
 */
class STCPayController extends Controller
{
    /**
     * Process STC Pay payment
     */
    public function process(Order $order)
    {
        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'stc_pay',
            'status' => 'pending',
            'amount' => $order->total_amount,
            'currency' => 'SAR',
        ]);

        // In production, integrate with STC Pay API
        // Example integration:
        // $stcPay = new STCPay(config('services.stc_pay'));
        // $response = $stcPay->initiatePayment([
        //     'amount' => $order->total_amount,
        //     'order_id' => $order->order_number,
        //     'callback_url' => route('payment.stc-pay.callback', $order),
        // ]);

        // For demo, simulate payment
        return redirect()->route('payment.stc-pay.simulate', $order);
    }

    /**
     * Simulate STC Pay payment (for testing)
     */
    public function simulate(Order $order)
    {
        return view('payments.stc-pay-simulate', compact('order'));
    }

    /**
     * Handle STC Pay callback
     */
    public function callback(Request $request, Order $order)
    {
        $payment = Payment::where('order_id', $order->id)
            ->where('payment_method', 'stc_pay')
            ->first();

        if (!$payment) {
            return redirect()->route('payment.failure', $order)
                ->with('error', __('Payment record not found.'));
        }

        // Verify payment with STC Pay API
        // $verification = $stcPay->verifyPayment($request->transaction_id);
        
        $status = $request->input('status', 'SUCCESS');

        if ($status === 'SUCCESS') {
            // Simulate success
            $payment->update([
                'status' => 'paid',
                'transaction_id' => 'STC-' . strtoupper(\Illuminate\Support\Str::random(12)),
                'gateway_response' => $request->all(),
                'paid_at' => now(),
            ]);

            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            return redirect()->route('payment.success', $order);
        } else {
            // Payment failed
            $payment->update([
                'status' => 'failed',
                'failed_at' => now(),
                'gateway_response' => $request->all(),
            ]);

            $order->update([
                'payment_status' => 'failed',
            ]);

            return redirect()->route('payment.failure', $order)
                ->with('error', __('Payment was declined or failed.'));
        }
    }

    /**
     * Handle STC Pay webhook
     */
    public function webhook(Request $request)
    {
        // Verify webhook signature
        // verifySTCPayWebhook($request);

        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($status === 'SUCCESS') {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'webhook_data' => $request->all(),
            ]);

            $payment->order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
        } elseif ($status === 'FAILED') {
            $payment->update([
                'status' => 'failed',
                'failed_at' => now(),
                'webhook_data' => $request->all(),
            ]);

            $payment->order->update([
                'payment_status' => 'failed',
            ]);
        }

        return response()->json(['success' => true]);
    }
}
