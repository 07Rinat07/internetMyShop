<?php

namespace App\Http\Resources\Api\V1;

use App\Support\Money\MoneyFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Payment
 */
class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        $status = $this->resource->statusEnum();
        $provider = $this->resource->providerEnum();

        return [
            'id' => $this->public_id,
            'amount' => MoneyFormatter::toNumeric((string) $this->amount),
            'currency' => $this->currency,
            'store_amount' => MoneyFormatter::toNumeric((string) $this->store_amount),
            'store_currency' => $this->store_currency,
            'conversion_rate' => MoneyFormatter::toNumeric((string) $this->conversion_rate, 6),
            'checkout_flow' => $this->checkout_flow,
            'status' => [
                'code' => $status->value,
                'label' => $status->label(),
            ],
            'provider' => [
                'code' => $provider->value,
                'label' => $provider->label(),
            ],
            'redirect_url' => $this->redirect_url,
            'failure_reason' => $this->failure_reason,
            'paid_at' => optional($this->paid_at)->toIso8601String(),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
            'order' => $this->whenLoaded('order', function () {
                /** @var \App\Models\Order $order */
                $order = $this->resource->getRelation('order');

                return (new OrderSummaryResource($order))->resolve();
            }),
        ];
    }
}
