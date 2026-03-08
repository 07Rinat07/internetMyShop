<?php

namespace App\Providers;

use App\Models\Basket;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    private const BRANDS_CACHE_KEY = 'layout.popular-brands';
    private const PAGES_CACHE_KEY = 'layout.pages';
    private const ROOTS_CACHE_KEY = 'layout.catalog-roots';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Category::saved(static fn () => Cache::forget(self::ROOTS_CACHE_KEY));
        Category::deleted(static fn () => Cache::forget(self::ROOTS_CACHE_KEY));
        Brand::saved(static fn () => Cache::forget(self::BRANDS_CACHE_KEY));
        Brand::deleted(static fn () => Cache::forget(self::BRANDS_CACHE_KEY));
        Page::saved(static fn () => Cache::forget(self::PAGES_CACHE_KEY));
        Page::deleted(static fn () => Cache::forget(self::PAGES_CACHE_KEY));

        View::composer('layout.part.roots', function($view) {
            $view->with(['items' => $this->remember(self::ROOTS_CACHE_KEY, static function () {
                return Category::roots();
            })]);
        });
        View::composer('layout.part.brands', function($view) {
            $view->with(['items' => $this->remember(self::BRANDS_CACHE_KEY, static function () {
                return Brand::popular();
            })]);
        });
        View::composer('layout.site', function($view) {
            $view->with(['positions' => Basket::getCount()]);
        });
        View::composer('layout.part.pages', function($view) {
            $view->with(['pages' => $this->remember(self::PAGES_CACHE_KEY, static function () {
                return Page::query()->orderBy('parent_id')->orderBy('name')->get();
            })]);
        });
    }

    private function remember(string $key, Closure $resolver): mixed
    {
        if (app()->runningUnitTests()) {
            return $resolver();
        }

        return Cache::remember($key, now()->addMinutes(10), $resolver);
    }
}
