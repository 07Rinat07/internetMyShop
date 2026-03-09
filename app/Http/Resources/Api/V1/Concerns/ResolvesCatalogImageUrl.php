<?php

namespace App\Http\Resources\Api\V1\Concerns;

trait ResolvesCatalogImageUrl
{
    protected function catalogImageUrl(?string $image, string $directory, string $variant = 'thumb'): ?string
    {
        if (empty($image)) {
            return null;
        }

        $appUrl = rtrim((string) config('app.url', ''), '/');
        $path = '/storage/catalog/'.$directory.'/'.$variant.'/'.basename($image);

        if ($appUrl !== '') {
            return $appUrl.$path;
        }

        return url($path);
    }
}
