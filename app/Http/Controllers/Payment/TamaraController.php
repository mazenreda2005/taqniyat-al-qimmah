<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Tamara (Buy Now Pay Later) Payment Controller
 * Handles Tamara BNPL payment integration
 */
class TamaraController extends Controller
{
    /**
     * Process Tamara payment
     */
    public function process(Order $order)
    {
        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'tamara',
            'status' => 'pending',
            'amount' => $order->total_amount,
            'currency' => 'SAR',
        ]);

        // In production, integrate with Tamara API
        // Example:
        // $tamara = new Tamara(config('services.tamara'));
        // $checkout = $tamara->createCheckout([
        //     'order_reference_id' => $order->order_number,
        //     'total_amount' => [
        //         'amount' => $order->total_amount,
        //         'currency' => 'SAR',
        //     ],
        //     'callback_url' => route('payment.tamara.callback', $order),
        // ]);

        // For demo, simulate payment
        return redirect()->route('payment.tamara.simulate', $order);
    }

    /**
     * Simulate Tamara payment (for testing)
     */
    public function simulate(Order $order)
    {
        return view('payments.tamara-simulate', compact('order'));
    }

    /**
     * Handle Tamara callback
     */
    public function callback(Request $request, Order $order)
    {
        $payment = Payment::where('order_id', $order->id)
            ->where('payment_method', 'tamara')
            ->first();

        if (!$payment) {
            return redirect()->route('payment.failure', $order)
                ->with('error', __('Payment record not found.'));
        }

        // Verify with Tamara API
        // $verification = $tamara->verifyOrder($request->order_id);
        
        $status = $request->input('status', 'approved');

        if ($status === 'approved') {
            // Simulate success
            $payment->update([
                'status' => 'paid',
                'transaction_id' => 'TMR-' . strtoupper(\Illuminate\Support\Str::random(12)),
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
     * Handle Tamara webhook
     */
    public function webhook(Request $request)
    {
        // Verify webhook signature
        // verifyTamaraWebhook($request);

        $orderId = $request->input('order_id');
        $status = $request->input('status');

        $payment = Payment::where('transaction_id', $orderId)
            ->orWhere('reference_number', $orderId)
            ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($status === 'approved') {
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'webhook_data' => $request->all(),
            ]);

            $payment->order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
        } elseif ($status === 'declined' || $status === 'canceled') {
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
