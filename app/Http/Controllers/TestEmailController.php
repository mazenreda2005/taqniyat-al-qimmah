<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Test Email Controller
 * Temporary controller for testing email configuration
 * 
 * IMPORTANT: Remove this controller and route after confirming email works
 */
class TestEmailController extends Controller
{
    /**
     * Send test email
     * 
     * Route: GET /test-email
     */
    public function sendTestEmail()
    {
        try {
            // إرسال بريد الاختبار إلى البريد المحدد في .env
            $testEmail = env('MAIL_FROM_ADDRESS', 'tqnyatalqmh@gmail.com');
            
            Mail::to($testEmail)->send(new TestMail());

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال رسالة الاختبار بنجاح',
                'sent_to' => $testEmail,
            ], 200);

        } catch (\Exception $e) {
            // تسجيل الخطأ في الـ logs
            Log::error('Test email failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال البريد الإلكتروني، تحقق من إعدادات SMTP وكلمة مرور التطبيق.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
