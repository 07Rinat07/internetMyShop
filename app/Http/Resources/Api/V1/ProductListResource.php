<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\V1\Concerns\ResolvesCatalogImageUrl;
use App\Support\Money\MoneyFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Product
 */
class ProductListResource extends JsonResource
{
    use ResolvesCatalogImageUrl;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => MoneyFormatter::toNumeric((string) $this->price),
            'image' => $this->catalogImageUrl($this->image, 'product', 'thumb'),
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
