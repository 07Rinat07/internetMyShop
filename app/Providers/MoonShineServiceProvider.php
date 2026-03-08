<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\Brand\BrandResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\Page\PageResource;
use App\MoonShine\Resources\Product\ProductResource;
use App\MoonShine\Resources\SiteContent\SiteContentResource;
use App\MoonShine\Resources\User\UserResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                CategoryResource::class,
                BrandResource::class,
                ProductResource::class,
                OrderResource::class,
                UserResource::class,
                SiteContentResource::class,
                PageResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ]);
    }
}
