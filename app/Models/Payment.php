<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Payment Model
 * Represents a payment transaction for an order
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'amount',
        'currency',
        'transaction_id',
        'reference_number',
        'receipt_path',
        'gateway_response',
        'webhook_data',
        'paid_at',
        'failed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'webhook_data' => 'array',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    /**
     * Payment methods
     */
    const METHOD_VISA_MADA = 'visa_mada';
    const METHOD_STC_PAY = 'stc_pay';
    const METHOD_TAMARA = 'tamara';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    const METHOD_CASH_ON_DELIVERY = 'cash_on_delivery';

    /**
     * Payment statuses
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Relationship: Payment belongs to Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            self::METHOD_VISA_MADA => __('Visa / MasterCard / Mada'),
            self::METHOD_STC_PAY => __('STC Pay'),
            self::METHOD_TAMARA => __('Tamara'),
            self::METHOD_BANK_TRANSFER => __('Bank Transfer'),
            self::METHOD_CASH_ON_DELIVERY => __('Cash on Delivery'),
            default => $this->payment_method,
        };
    }

    /**
     * Get payment status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_PAID => __('Paid'),
            self::STATUS_FAILED => __('Failed'),
            self::STATUS_UNDER_REVIEW => __('Under Review'),
            self::STATUS_REFUNDED => __('Refunded'),
            self::STATUS_CANCELLED => __('Cancelled'),
            default => $this->status,
        };
    }

    /**
     * Check if payment is successful
     */
    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if payment is under review (bank transfer)
     */
    public function isUnderReview()
    {
        return $this->status === self::STATUS_UNDER_REVIEW;
    }
}
