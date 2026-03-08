<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Order;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\MoonShine\Resources\Order\Pages\OrderDetailPage;
use App\MoonShine\Resources\Order\Pages\OrderFormPage;
use App\MoonShine\Resources\Order\Pages\OrderIndexPage;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Order, OrderIndexPage, OrderFormPage, OrderDetailPage>
 */
class OrderResource extends ModelResource
{
    protected string $model = Order::class;

    protected string $title = 'Заказы';

    protected string $sortColumn = 'created_at';

    protected SortDirection $sortDirection = SortDirection::DESC;

    protected int $itemsPerPage = 15;

    protected array $with = ['user'];

    protected function onBoot(): void
    {
        $this->alias('orders');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            OrderIndexPage::class,
            OrderFormPage::class,
            OrderDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Date::make('Создан', 'created_at')->format('d.m.Y H:i')->sortable(),
            Text::make('Покупатель', 'name'),
            Text::make('Email', 'email'),
            Text::make('Сумма', formatted: static fn (Order $order) => number_format((float) $order->amount, 0, '.', ' ') . ' ₸'),
            Text::make('Статус', formatted: static fn (Order $order) => $order->statusEnum()->label()),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Select::make('Статус', 'status')
                    ->options(OrderStatus::labels())
                    ->required(),
                Text::make('Покупатель', 'name')->previewMode(),
                Text::make('Email', 'email')->previewMode(),
                Text::make('Телефон', 'phone')->previewMode(),
                Text::make('Адрес', 'address')->previewMode(),
                Text::make('Сумма', formatted: static fn (Order $order) => number_format((float) $order->amount, 0, '.', ' ') . ' ₸')->previewMode(),
                Textarea::make('Комментарий', 'comment')->previewMode(),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Date::make('Создан', 'created_at')->format('d.m.Y H:i'),
            Text::make('Покупатель', 'name'),
            Text::make('Email', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Адрес', 'address'),
            Text::make('Статус', formatted: static fn (Order $order) => $order->statusEnum()->label()),
            Text::make('Сумма', formatted: static fn (Order $order) => number_format((float) $order->amount, 0, '.', ' ') . ' ₸'),
            Text::make('Пользователь сайта', formatted: static fn (Order $order) => $order->user?->name ?? 'Гость'),
            Textarea::make('Комментарий', 'comment'),
        ];
    }

    public function filtersFields(): array
    {
        return [];
    }

    public function formRules(DataWrapperContract $item): array
    {
        return [
            'status' => ['required', 'integer', Rule::in(OrderStatus::values())],
        ];
    }

    protected function activeActions(): ListOf
    {
        return new ListOf(Action::class, [
            Action::VIEW,
            Action::UPDATE,
        ]);
    }

    protected function search(): array
    {
        return ['id', 'name', 'email', 'phone', 'address'];
    }
}
