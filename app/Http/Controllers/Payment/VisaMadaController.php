<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Visa / MasterCard / Mada Payment Controller
 * Handles online card payments
 */
class VisaMadaController extends Controller
{
    /**
     * Process Visa/Mada payment
     * Redirects to payment gateway
     */
    public function process(Order $order)
    {
        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'visa_mada',
            'status' => 'pending',
            'amount' => $order->total_amount,
            'currency' => 'SAR',
        ]);

        // In production, integrate with actual payment gateway (e.g., Tap Payments, PayTabs)
        // For now, we'll simulate the gateway redirect
        
        // Example: Tap Payments integration
        // $gateway = new TapPayments(config('services.tap'));
        // $response = $gateway->createCharge([
        //     'amount' => $order->total_amount,
        //     'currency' => 'SAR',
        //     'customer' => [...],
        //     'redirect' => route('payment.visa-mada.callback', $order),
        // ]);
        
        // For demo purposes, we'll redirect to a simulated payment page
        return redirect()->route('payment.visa-mada.simulate', $order);
    }

    /**
     * Simulate payment gateway (for testing)
     * In production, this would be handled by the actual gateway
     */
    public function simulate(Order $order)
    {
        return view('payments.visa-mada-simulate', compact('order'));
    }

    /**
     * Handle payment gateway callback
     */
    public function callback(Request $request, Order $order)
    {
        // Verify payment with gateway
        // $gatewayResponse = verifyPayment($request->tap_id);
        
        // For demo, simulate success or failure based on status parameter
        $payment = Payment::where('order_id', $order->id)
            ->where('payment_method', 'visa_mada')
            ->first();

        if (!$payment) {
            return redirect()->route('payment.failure', $order)
                ->with('error', __('Payment record not found.'));
        }

        $status = $request->input('status', 'success');

        if ($status === 'success' || $status === 'paid') {
            // Simulate payment success (in production, verify with gateway)
            $payment->update([
                'status' => 'paid',
                'transaction_id' => 'TXN-' . strtoupper(\Illuminate\Support\Str::random(12)),
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
     * Handle webhook from payment gateway
     */
    public function webhook(Request $request)
    {
        // Verify webhook signature
        // $signature = $request->header('X-Tap-Signature');
        // verifyWebhookSignature($signature, $request->all());

        $transactionId = $request->input('id');
        $status = $request->input('status');

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Update payment status based on webhook
        if ($status === 'CAPTURED') {
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
