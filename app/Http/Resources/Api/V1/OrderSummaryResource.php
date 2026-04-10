<?php

namespace App\Http\Resources\Api\V1;

use App\Support\Money\MoneyFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Order
 */
class OrderSummaryResource extends JsonResource
{
    public function toArray($request)
    {
        $status = $this->resource->statusEnum();
        $paymentMethod = $this->resource->paymentMethodEnum();

        return [
            'id' => $this->id,
            'amount' => MoneyFormatter::toNumeric((string) $this->amount),
            'currency' => $this->currency,
            'status' => [
                'code' => $status->value,
                'label' => $status->label(),
            ],
            'payment_method' => [
                'code' => $paymentMethod->value,
                'label' => $paymentMethod->label(),
            ],
            'items_count' => (int) ($this->items_count ?? $this->items->count()),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
