<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\V1\Concerns\ResolvesCatalogImageUrl;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Brand
 */
class BrandResource extends JsonResource
{
    use ResolvesCatalogImageUrl;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->catalogImageUrl($this->image, 'brand', 'thumb'),
            'products_count' => $this->whenCounted('products'),
        ];
    }
}
