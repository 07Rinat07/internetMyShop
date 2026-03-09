<?php

namespace App\Http\Resources\Api\V1;

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
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'store_amount' => (float) $this->store_amount,
            'store_currency' => $this->store_currency,
            'conversion_rate' => (float) $this->conversion_rate,
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
