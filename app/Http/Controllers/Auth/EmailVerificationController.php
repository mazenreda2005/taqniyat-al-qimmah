<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    /**
     * عرض صفحة إدخال رمز التحقق
     */
    public function showEnterCodeForm(Request $request)
    {
        $email = $request->session()->get('pending_verification_email');
        if (!$email) {
            return redirect()->route('login')->with('error', __('Please log in first to verify your email.'));
        }

        return view('auth.verify-email', ['email' => $email]);
    }

    /**
     * التحقق من الرمز المُدخل (يُقارن مع الرمز المخزّن في الجلسة)
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $email = $request->session()->get('pending_verification_email');
        if (!$email) {
            return redirect()->route('login')->with('error', __('Please log in first to verify your email.'));
        }

        // تطبيع الرمز: أرقام فقط (لتفادي المسافات أو نسخ خاطئ)
        $enteredCode = preg_replace('/\D/', '', $request->code);
        if (strlen($enteredCode) !== 6) {
            return back()->with('error', __('Invalid or expired code. Please try again or request a new code.'));
        }

        $storedCode = $request->session()->get('pending_verification_otp');
        if ($storedCode === null || (string) $storedCode !== $enteredCode) {
            return back()->with('error', __('Invalid or expired code. Please try again or request a new code.'));
        }

        $request->session()->forget('pending_verification_otp');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', __('User not found.'));
        }

        $user->markEmailAsVerified();
        $request->session()->forget('pending_verification_email');
        Auth::login($user, $request->boolean('remember', false));

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))->with('success', __('Your email has been verified successfully.'));
        }

        return redirect()->intended(route('home'))->with('success', __('Your email has been verified successfully.'));
    }

    /**
     * إعادة إرسال رمز التحقق (رمز جديد في الجلسة)
     */
    public function resendCode(Request $request)
    {
        $email = $request->session()->get('pending_verification_email');
        if (!$email) {
            return redirect()->route('login')->with('error', __('Please log in first to verify your email.'));
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', __('User not found.'));
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', __('Verification code has been sent to your email.'));
    }
}
