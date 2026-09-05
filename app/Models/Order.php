<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(10));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship: Order has one Payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'visa_mada' => __('Visa / MasterCard / Mada'),
            'stc_pay' => __('STC Pay'),
            'tamara' => __('Tamara'),
            'bank_transfer' => __('Bank Transfer'),
            'cash_on_delivery' => __('Cash on Delivery'),
            default => $this->payment_method ?? __('Not Selected'),
        };
    }

    /**
     * Get payment status label
     */
    public function getPaymentStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'pending' => __('Pending'),
            'paid' => __('Paid'),
            'failed' => __('Failed'),
            'under_review' => __('Under Review'),
            'refunded' => __('Refunded'),
            default => $this->payment_status ?? __('Pending'),
        };
    }

    /**
     * Check if order payment is completed
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if payment is under review (bank transfer)
     */
    public function isPaymentUnderReview()
    {
        return $this->payment_status === 'under_review';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => __('Pending'),
            'processing' => __('Processing'),
            'shipped' => __('Shipped'),
            'delivered' => __('Delivered'),
            'cancelled' => __('Cancelled'),
            default => $this->status,
        };
    }
}
