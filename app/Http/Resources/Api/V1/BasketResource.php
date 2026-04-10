<?php

namespace App\Http\Resources\Api\V1;

use App\Support\Money\MoneyFormatter;
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
            'amount' => MoneyFormatter::toNumeric($this->getAmount()),
            'items' => BasketItemResource::collection($this->products),
        ];
    }
}
