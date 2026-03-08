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
        return $this->title ?: 'Панель управления';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        return [
            Box::make([
                FlexibleRender::make('<span class="ims-dashboard-hero__eyebrow">Premium Expedition Admin</span>'),
                Heading::make('Управление каталогом, заказами и контентом магазина', 2),
                FlexibleRender::make(
                    '<p class="ims-dashboard-hero__text">Панель собрана как control room для витрины: работайте с каталогом, отслеживайте заказы, управляйте пользователями и быстро возвращайтесь на storefront без лишних переходов.</p>'
                ),
                Div::make([
                    ActionButton::make(
                        'Товары',
                        app(ProductResource::class)->getIndexPageUrl()
                    )->primary(),
                    ActionButton::make(
                        'Заказы',
                        app(OrderResource::class)->getIndexPageUrl()
                    )->secondary(),
                    ActionButton::make(
                        'Пользователи',
                        app(UserResource::class)->getIndexPageUrl()
                    )->secondary(),
                    ActionButton::make(
                        'Контент витрины',
                        app(SiteContentResource::class)->getIndexPageUrl()
                    )->secondary(),
                    ActionButton::make('На сайт', route('index'))->info(),
                ])->class('ims-dashboard-actions'),
            ])->class('ims-dashboard-hero'),
            Grid::make([
                $this->statCard('Товары', Product::query()->count(), 'Витрина, карточки и товарные коллекции'),
                $this->statCard('Категории', Category::query()->count(), 'Навигационные разделы каталога'),
                $this->statCard('Бренды', Brand::query()->count(), 'Марки и брендовые подборки'),
                $this->statCard('Заказы', Order::query()->count(), 'Текущая обработка заказов'),
                $this->statCard('Пользователи', User::query()->count(), 'Аккаунты и доступ в магазин'),
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
