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

    protected string $title = '';

    protected string $sortColumn = 'created_at';

    protected SortDirection $sortDirection = SortDirection::DESC;

    protected int $itemsPerPage = 15;

    protected array $with = ['user', 'payments'];

    protected function onBoot(): void
    {
        $this->title = __('admin.resources.order.title');
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
            Date::make(__('admin.fields.created_at'), 'created_at')->format('d.m.Y H:i')->sortable(),
            Text::make(__('admin.fields.customer'), 'name'),
            Text::make(__('admin.fields.email'), 'email'),
            Text::make(__('admin.fields.payment'), formatted: static fn (Order $order) => $order->paymentMethodEnum()->label()),
            Text::make(__('admin.fields.amount'), formatted: static fn (Order $order) => number_format((float) $order->amount, 0, '.', ' ') . ' ₸'),
            Text::make(__('admin.fields.status'), formatted: static fn (Order $order) => $order->statusEnum()->label()),
            Text::make(__('admin.fields.payment_status'), formatted: static fn (Order $order) => $order->payments->sortByDesc('created_at')->first()?->statusEnum()->label() ?? __('admin.common.none')),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Select::make(__('admin.fields.status'), 'status')
                    ->options(OrderStatus::labels())
                    ->required(),
                Text::make(__('admin.fields.customer'), 'name')->previewMode(),
                Text::make(__('admin.fields.email'), 'email')->previewMode(),
                Text::make(__('admin.fields.phone'), 'phone')->previewMode(),
                Text::make(__('admin.fields.address'), 'address')->previewMode(),
                Text::make(__('admin.fields.payment_method'), formatted: static fn (Order $order) => $order->paymentMethodEnum()->label())->previewMode(),
                Text::make(__('admin.fields.amount'), formatted: static fn (Order $order) => number_format((float) $order->amount, 0, '.', ' ') . ' ₸')->previewMode(),
                Text::make(__('admin.fields.payment_status'), formatted: static fn (Order $order) => $order->payments->sortByDesc('created_at')->first()?->statusEnum()->label() ?? __('admin.common.none'))->previewMode(),
                Textarea::make(__('admin.fields.comment'), 'comment')->previewMode(),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Date::make(__('admin.fields.created_at'), 'created_at')->format('d.m.Y H:i'),
            Text::make(__('admin.fields.customer'), 'name'),
            Text::make(__('admin.fields.email'), 'email'),
            Text::make(__('admin.fields.phone'), 'phone'),
            Text::make(__('admin.fields.address'), 'address'),
            Text::make(__('admin.fields.status'), formatted: static fn (Order $order) => $order->statusEnum()->label()),
            Text::make(__('admin.fields.payment_method'), formatted: static fn (Order $order) => $order->paymentMethodEnum()->label()),
            Text::make(__('admin.fields.payment_status'), formatted: static fn (Order $order) => $order->payments->sortByDesc('created_at')->first()?->statusEnum()->label() ?? __('admin.common.none')),
            Text::make(__('admin.fields.amount'), formatted: static fn (Order $order) => number_format((float) $order->amount, 0, '.', ' ') . ' ₸'),
            Text::make(__('admin.fields.site_user'), formatted: static fn (Order $order) => $order->user?->name ?? __('admin.common.guest')),
            Textarea::make(__('admin.fields.comment'), 'comment'),
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
