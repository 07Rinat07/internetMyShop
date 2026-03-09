<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Created = 'created';
    case Pending = 'pending';
    case RequiresAction = 'requires_action';
    case Succeeded = 'succeeded';
    case Failed = 'failed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Created => __('site.payment_status.created'),
            self::Pending => __('site.payment_status.pending'),
            self::RequiresAction => __('site.payment_status.requires_action'),
            self::Succeeded => __('site.payment_status.succeeded'),
            self::Failed => __('site.payment_status.failed'),
            self::Cancelled => __('site.payment_status.cancelled'),
            self::Expired => __('site.payment_status.expired'),
        };
    }
}
