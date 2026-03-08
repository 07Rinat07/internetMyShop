<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Basket
 */
class BasketResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'positions' => $this->products->count(),
            'amount' => $this->getAmount(),
            'items' => BasketItemResource::collection($this->products),
        ];
    }
}
