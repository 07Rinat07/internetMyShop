<?php

namespace App\Models;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'public_id',
        'order_id',
        'provider',
        'status',
        'amount',
        'currency',
        'store_amount',
        'store_currency',
        'conversion_rate',
        'checkout_flow',
        'provider_payment_id',
        'provider_operation_id',
        'redirect_url',
        'paid_at',
        'failed_at',
        'cancelled_at',
        'last_webhook_at',
        'failure_reason',
        'raw_create_payload',
        'raw_create_response',
        'raw_webhook_payload',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'store_amount' => 'decimal:2',
        'conversion_rate' => 'decimal:6',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'last_webhook_at' => 'datetime',
        'raw_create_payload' => 'array',
        'raw_create_response' => 'array',
        'raw_webhook_payload' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $payment): void {
            $payment->public_id ??= (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'public_id';
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function statusEnum(): PaymentStatus
    {
        return PaymentStatus::from((string) $this->status);
    }

    public function providerEnum(): PaymentProvider
    {
        return PaymentProvider::from((string) $this->provider);
    }
}
