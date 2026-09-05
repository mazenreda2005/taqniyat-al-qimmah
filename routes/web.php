<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetOtpController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Payment\BankTransferController;
use App\Http\Controllers\Payment\CashOnDeliveryController;
use App\Http\Controllers\Payment\STCPayController;
use App\Http\Controllers\Payment\TamaraController;
use App\Http\Controllers\Payment\VisaMadaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// تغيير اللغة (يُخزَّن في الجلسة)
Route::get('/locale/{locale}', function (string $locale) {
    $locales = config('app.locales', []);
    if (!isset($locales[$locale])) {
        return redirect()->back();
    }
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale.switch');

// API Route for Slider Products (public)
Route::get('/api/slider-products', [HomeController::class, 'getSliderProducts'])->name('api.slider.products');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Forgot password (OTP via email)
    Route::get('/forgot-password', [PasswordResetOtpController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('/forgot-password', [PasswordResetOtpController::class, 'sendOtp'])->name('password.forgot.send');
    Route::get('/forgot-password/otp', [PasswordResetOtpController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/forgot-password/otp', [PasswordResetOtpController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::post('/forgot-password/otp/resend', [PasswordResetOtpController::class, 'resendOtp'])->middleware('throttle:3,1')->name('password.otp.resend');
    Route::get('/reset-password', [PasswordResetOtpController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [PasswordResetOtpController::class, 'resetPassword'])->name('password.reset');
});

// Email Verification (OTP) - صفحة إدخال رمز التحقق
Route::middleware('guest')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'showEnterCodeForm'])->name('verification.notice');
    Route::post('/email/verify', [EmailVerificationController::class, 'verifyCode'])->name('verification.verify-code');
    Route::post('/email/resend-code', [EmailVerificationController::class, 'resendCode'])->middleware('throttle:3,1')->name('verification.resend-code');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile Routes (لا تحتاج verified)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Routes التي تحتاج verified email
Route::middleware(['auth', 'verified'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Maintenance Routes
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');

    // Payment Routes
    Route::get('/payment/process/{order}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failure/{order}', [PaymentController::class, 'failure'])->name('payment.failure');
    
    // Visa/Mada Payment
    Route::get('/payment/visa-mada/process/{order}', [VisaMadaController::class, 'process'])->name('payment.visa-mada.process');
    Route::get('/payment/visa-mada/simulate/{order}', [VisaMadaController::class, 'simulate'])->name('payment.visa-mada.simulate');
    Route::get('/payment/visa-mada/callback/{order}', [VisaMadaController::class, 'callback'])->name('payment.visa-mada.callback');
    
    // STC Pay
    Route::get('/payment/stc-pay/process/{order}', [STCPayController::class, 'process'])->name('payment.stc-pay.process');
    Route::get('/payment/stc-pay/simulate/{order}', [STCPayController::class, 'simulate'])->name('payment.stc-pay.simulate');
    Route::get('/payment/stc-pay/callback/{order}', [STCPayController::class, 'callback'])->name('payment.stc-pay.callback');
    
    // Tamara
    Route::get('/payment/tamara/process/{order}', [TamaraController::class, 'process'])->name('payment.tamara.process');
    Route::get('/payment/tamara/simulate/{order}', [TamaraController::class, 'simulate'])->name('payment.tamara.simulate');
    Route::get('/payment/tamara/callback/{order}', [TamaraController::class, 'callback'])->name('payment.tamara.callback');
    
    // Bank Transfer
    Route::get('/payment/bank-transfer/{order}', [BankTransferController::class, 'show'])->name('payment.bank-transfer.show');
    Route::post('/payment/bank-transfer/upload/{order}', [PaymentController::class, 'uploadReceipt'])->name('payment.bank-transfer.upload');
    
    // Cash on Delivery
    Route::get('/payment/cash-on-delivery/confirm/{order}', [CashOnDeliveryController::class, 'confirm'])->name('payment.cash-on-delivery.confirm');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Maintenance
    Route::get('/maintenance', [AdminMaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/{maintenanceRequest}', [AdminMaintenanceController::class, 'show'])->name('maintenance.show');
    Route::put('/maintenance/{maintenanceRequest}', [AdminMaintenanceController::class, 'update'])->name('maintenance.update');

    // Slider Management
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::put('/slider/products', [SliderController::class, 'updateProducts'])->name('slider.products');
    Route::put('/slider/settings', [SliderController::class, 'updateSettings'])->name('slider.settings');

    // Payment Management
    Route::post('/payments/{payment}/approve', [AdminOrderController::class, 'approvePayment'])->name('payments.approve');
    Route::post('/payments/{payment}/reject', [AdminOrderController::class, 'rejectPayment'])->name('payments.reject');
});

// Webhook Routes (no auth required, but should verify signature)
Route::post('/webhooks/visa-mada', [VisaMadaController::class, 'webhook'])->name('webhooks.visa-mada');
Route::post('/webhooks/stc-pay', [STCPayController::class, 'webhook'])->name('webhooks.stc-pay');
Route::post('/webhooks/tamara', [TamaraController::class, 'webhook'])->name('webhooks.tamara');
