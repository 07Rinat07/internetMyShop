<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\V1\Concerns\ResolvesCatalogImageUrl;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Category
 */
class CategoryTreeResource extends JsonResource
{
    use ResolvesCatalogImageUrl;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->catalogImageUrl($this->image, 'category', 'thumb'),
            'children' => CategoryTreeResource::collection($this->whenLoaded('children')),
        ];
    }
}
