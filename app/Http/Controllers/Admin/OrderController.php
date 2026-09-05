<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // افتراضياً لا نظهر الطلبات الملغاة في قائمة الإدارة
        $query = Order::with('user', 'payment')
            ->when(!$request->filled('status'), function ($q) {
                $q->where('status', '!=', 'cancelled');
            });

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by order status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // إرسال بريد للمستخدم عند الموافقة على الطلب أو رفضه
        if (in_array($order->status, ['processing', 'cancelled'], true)) {
            try {
                $order->loadMissing(['user']);
                Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
            } catch (\Throwable $e) {
                // لا نكسر الصفحة لو حصل خطأ أثناء إرسال الإيميل
            }
        }

        return back()->with('success', __('Order status updated successfully.'));
    }

    /**
     * Approve bank transfer payment
     */
    public function approvePayment(Request $request, Payment $payment)
    {
        if ($payment->payment_method !== 'bank_transfer') {
            return back()->with('error', __('This payment is not a bank transfer.'));
        }

        if ($payment->status !== 'under_review') {
            return back()->with('error', __('This payment is not under review.'));
        }

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $payment->order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        return back()->with('success', __('Payment approved successfully.'));
    }

    /**
     * Reject bank transfer payment
     */
    public function rejectPayment(Request $request, Payment $payment)
    {
        if ($payment->payment_method !== 'bank_transfer') {
            return back()->with('error', __('This payment is not a bank transfer.'));
        }

        if ($payment->status !== 'under_review') {
            return back()->with('error', __('This payment is not under review.'));
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'status' => 'failed',
            'failed_at' => now(),
            'gateway_response' => array_merge(
                $payment->gateway_response ?? [],
                ['rejection_reason' => $request->rejection_reason]
            ),
        ]);

        $payment->order->update([
            'payment_status' => 'failed',
        ]);

        return back()->with('success', __('Payment rejected successfully.'));
    }
}
