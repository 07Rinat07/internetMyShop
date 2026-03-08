<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class BasketItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'quantity' => (int) $this->pivot->quantity,
            'cost' => $this->price * $this->pivot->quantity,
            'image' => $this->image,
            'flags' => [
                'new' => (bool) $this->new,
                'hit' => (bool) $this->hit,
                'sale' => (bool) $this->sale,
            ],
            'brand' => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
                'slug' => $this->brand->slug,
            ] : null,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
        ];
    }
}
