<?php

namespace App\Models;

use App\Mail\VerificationCodeMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * إرسال رمز التحقق (OTP) إلى البريد - الرمز يُخزَّن في الجلسة من الـ Controller
     */
    public function sendVerificationCodeEmail(string $code): void
    {
        Mail::to($this->email)->send(new VerificationCodeMail($this->email, $code));
    }

    /**
     * إرسال رمز التحقق (للتوافق مع حدث التسجيل) - يُستخدم عند وجود الرمز في الجلسة
     */
    public function sendEmailVerificationNotification(): void
    {
        $code = (string) random_int(100000, 999999);
        app('session')->put('pending_verification_otp', $code);
        Mail::to($this->email)->send(new VerificationCodeMail($this->email, $code));
    }
}
