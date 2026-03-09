<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\Product\ProductResource;
use App\MoonShine\Resources\SiteContent\SiteContentResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\FlexibleRender;
use MoonShine\UI\Components\Heading;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Div;
use MoonShine\UI\Components\Layout\Grid;

#[\MoonShine\MenuManager\Attributes\SkipMenu]

class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: __('admin.dashboard.title');
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        return [
            Box::make([
                FlexibleRender::make(sprintf('<span class="ims-dashboard-hero__eyebrow">%s</span>', e(__('admin.dashboard.eyebrow')))),
                Heading::make(__('admin.dashboard.heading'), 2),
                FlexibleRender::make(
                    sprintf('<p class="ims-dashboard-hero__text">%s</p>', e(__('admin.dashboard.description')))
                ),
                Div::make([
                    ActionButton::make(
                        __('admin.dashboard.actions.products'),
                        app(ProductResource::class)->getIndexPageUrl()
                    )->primary(),
                    ActionButton::make(
                        __('admin.dashboard.actions.orders'),
                        app(OrderResource::class)->getIndexPageUrl()
                    )->secondary(),
                    ActionButton::make(
                        __('admin.dashboard.actions.users'),
                        app(UserResource::class)->getIndexPageUrl()
                    )->secondary(),
                    ActionButton::make(
                        __('admin.dashboard.actions.site_content'),
                        app(SiteContentResource::class)->getIndexPageUrl()
                    )->secondary(),
                    ActionButton::make(__('admin.dashboard.actions.to_site'), route('index'))->info(),
                ])->class('ims-dashboard-actions'),
            ])->class('ims-dashboard-hero'),
            Grid::make([
                $this->statCard(__('admin.dashboard.stats.products_label'), Product::query()->count(), __('admin.dashboard.stats.products_note')),
                $this->statCard(__('admin.dashboard.stats.categories_label'), Category::query()->count(), __('admin.dashboard.stats.categories_note')),
                $this->statCard(__('admin.dashboard.stats.brands_label'), Brand::query()->count(), __('admin.dashboard.stats.brands_note')),
                $this->statCard(__('admin.dashboard.stats.orders_label'), Order::query()->count(), __('admin.dashboard.stats.orders_note')),
                $this->statCard(__('admin.dashboard.stats.users_label'), User::query()->count(), __('admin.dashboard.stats.users_note')),
            ])->class('ims-stat-grid'),
        ];
    }

    private function statCard(string $label, int $value, string $note): Box
    {
        return Box::make([
            FlexibleRender::make(sprintf('<span class="ims-stat-card__label">%s</span>', e($label))),
            FlexibleRender::make(sprintf('<strong class="ims-stat-card__value">%d</strong>', $value)),
            FlexibleRender::make(sprintf('<span class="ims-stat-card__note">%s</span>', e($note))),
        ])->class('ims-stat-card');
    }
}
