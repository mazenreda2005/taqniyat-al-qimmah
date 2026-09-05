<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class PasswordResetOtpController extends Controller
{
    /**
     * صفحة "نسيت كلمة السر"
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * إرسال OTP على الإيميل
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', __('No account found with this email.'));
        }

        $code = (string) random_int(100000, 999999);
        $request->session()->put('password_reset_email', $user->email);
        $request->session()->put('password_reset_otp', $code);
        $request->session()->put('password_reset_otp_expires_at', now()->addMinutes(10)->timestamp);
        $request->session()->forget('password_reset_verified');

        try {
            Mail::to($user->email)->send(new PasswordResetOtpMail($user->email, $code));
        } catch (\Throwable $e) {
            return back()->with('error', __('Failed to send reset code. Please try again.'));
        }

        return redirect()->route('password.otp.form')
            ->with('success', __('Reset code has been sent to your email.'));
    }

    /**
     * صفحة إدخال OTP
     */
    public function showOtpForm(Request $request)
    {
        $email = $request->session()->get('password_reset_email');
        if (!$email) {
            return redirect()->route('password.forgot')->with('error', __('Please enter your email first.'));
        }

        return view('auth.reset-password-otp', ['email' => $email]);
    }

    /**
     * التحقق من OTP ثم السماح بتغيير كلمة السر
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $email = $request->session()->get('password_reset_email');
        $storedCode = $request->session()->get('password_reset_otp');
        $expiresAt = (int) $request->session()->get('password_reset_otp_expires_at', 0);

        if (!$email || !$storedCode) {
            return redirect()->route('password.forgot')->with('error', __('Please request a reset code first.'));
        }

        $enteredCode = preg_replace('/\D/', '', $request->code);
        if (strlen($enteredCode) !== 6) {
            return back()->with('error', __('Invalid or expired code. Please try again.'));
        }

        if ($expiresAt > 0 && now()->timestamp > $expiresAt) {
            return back()->with('error', __('Invalid or expired code. Please request a new one.'));
        }

        if ((string) $storedCode !== (string) $enteredCode) {
            return back()->with('error', __('Invalid or expired code. Please try again.'));
        }

        $request->session()->put('password_reset_verified', true);

        return redirect()->route('password.reset.form')->with('success', __('Code verified. Please set a new password.'));
    }

    /**
     * صفحة تعيين كلمة سر جديدة
     */
    public function showResetForm(Request $request)
    {
        $email = $request->session()->get('password_reset_email');
        $verified = (bool) $request->session()->get('password_reset_verified', false);

        if (!$email) {
            return redirect()->route('password.forgot')->with('error', __('Please enter your email first.'));
        }
        if (!$verified) {
            return redirect()->route('password.otp.form')->with('error', __('Please verify the code first.'));
        }

        return view('auth.reset-password', ['email' => $email]);
    }

    /**
     * تحديث كلمة السر
     */
    public function resetPassword(Request $request)
    {
        $email = $request->session()->get('password_reset_email');
        $verified = (bool) $request->session()->get('password_reset_verified', false);

        if (!$email || !$verified) {
            return redirect()->route('password.forgot')->with('error', __('Please request and verify a reset code first.'));
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.forgot')->with('error', __('User not found.'));
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $request->session()->forget([
            'password_reset_email',
            'password_reset_otp',
            'password_reset_otp_expires_at',
            'password_reset_verified',
        ]);

        return redirect()->route('login')->with('success', __('Your password has been reset successfully. Please log in.'));
    }

    /**
     * إعادة إرسال OTP
     */
    public function resendOtp(Request $request)
    {
        $email = $request->session()->get('password_reset_email');
        if (!$email) {
            return redirect()->route('password.forgot')->with('error', __('Please enter your email first.'));
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.forgot')->with('error', __('User not found.'));
        }

        $code = (string) random_int(100000, 999999);
        $request->session()->put('password_reset_otp', $code);
        $request->session()->put('password_reset_otp_expires_at', now()->addMinutes(10)->timestamp);
        $request->session()->forget('password_reset_verified');

        try {
            Mail::to($user->email)->send(new PasswordResetOtpMail($user->email, $code));
        } catch (\Throwable $e) {
            return back()->with('error', __('Failed to send reset code. Please try again.'));
        }

        return back()->with('success', __('Reset code has been sent to your email.'));
    }
}

