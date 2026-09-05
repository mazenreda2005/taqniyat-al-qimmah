<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmationMail;
use App\Mail\AdminNewOrderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // إخفاء الطلبات الملغاة من صفحة المستخدم
        $orders = Auth::user()
            ->orders()
            ->with('items.product')
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty.'));
        }

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', __('Some products are out of stock.'));
            }
        }

        return view('orders.checkout', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:visa_mada,stc_pay,tamara,bank_transfer,cash_on_delivery',
        ]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty.'));
        }

        DB::beginTransaction();
        try {
            $totalAmount = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Determine initial order status based on payment method
            $initialStatus = $request->payment_method === 'cash_on_delivery' ? 'processing' : 'pending';
            $paymentStatus = $request->payment_method === 'bank_transfer' ? 'under_review' : 'pending';

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => $initialStatus,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            Auth::user()->cartItems()->delete();

            DB::commit();

            // تحميل العلاقات المطلوبة للبريد
            $order->load(['user', 'items.product']);

            // إرسال بريد تأكيد الطلب للمستخدم
            try {
                Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                // في حالة فشل إرسال البريد، لا نوقف العملية
                Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // إرسال إشعار للأدمن بوجود طلب جديد
            try {
                $adminEmail = config('mail.admin_address', env('MAIL_FROM_ADDRESS'));
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminNewOrderMail($order));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send admin new order email: ' . $e->getMessage());
            }

            // Redirect to payment processing based on method
            return redirect()->route('payment.process', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('An error occurred while processing your order.'));
        }
    }
}
