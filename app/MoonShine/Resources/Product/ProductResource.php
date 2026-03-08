<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\MoonShine\Resources\Brand\BrandResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Product\Pages\ProductDetailPage;
use App\MoonShine\Resources\Product\Pages\ProductFormPage;
use App\MoonShine\Resources\Product\Pages\ProductIndexPage;
use App\MoonShine\Resources\Support\CatalogModelResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends CatalogModelResource<Product, ProductIndexPage, ProductFormPage, ProductDetailPage>
 */
class ProductResource extends CatalogModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Товары';

    protected string $column = 'name';

    protected string $sortColumn = 'created_at';

    protected SortDirection $sortDirection = SortDirection::DESC;

    protected int $itemsPerPage = 15;

    protected array $with = ['category', 'brand'];

    protected function onBoot(): void
    {
        $this->alias('products');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ProductIndexPage::class,
            ProductFormPage::class,
            ProductDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            $this->previewField('Фото')->columnSelection(false),
            Text::make('Название', 'name')->sortable(),
            Text::make('Слаг', 'slug'),
            Text::make('Категория', formatted: static fn (Product $product) => $product->category?->name ?? 'Не выбрана'),
            Text::make('Бренд', formatted: static fn (Product $product) => $product->brand?->name ?? 'Не выбран'),
            Text::make('Цена', formatted: static fn (Product $product) => number_format((float) $product->price, 0, '.', ' ') . ' ₸')->sortable('price'),
            Text::make('Флаги', formatted: static fn (Product $product) => implode(', ', array_filter([
                $product->new ? 'New' : null,
                $product->hit ? 'Hit' : null,
                $product->sale ? 'Sale' : null,
            ])) ?: 'Нет'),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Flex::make([
                    Text::make('Название', 'name')->required(),
                    Slug::make('Слаг', 'slug')->from('name')->live(),
                ]),
                Flex::make([
                    BelongsTo::make(
                        'Категория',
                        'category',
                        formatted: static fn (Category $category) => $category->name,
                        resource: CategoryResource::class,
                    )->valuesQuery(static fn (Builder $query) => $query->select(['id', 'name']))->required(),
                    BelongsTo::make(
                        'Бренд',
                        'brand',
                        formatted: static fn (Brand $brand) => $brand->name,
                        resource: BrandResource::class,
                    )->valuesQuery(static fn (Builder $query) => $query->select(['id', 'name']))->required(),
                ]),
                Textarea::make('Описание', 'content')->nullable(),
                $this->uploadField(),
                Number::make('Цена', 'price')->min(1)->step(1)->required(),
                Flex::make([
                    Switcher::make('Новинка', 'new'),
                    Switcher::make('Хит', 'hit'),
                    Switcher::make('Распродажа', 'sale'),
                ]),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            $this->previewField('Изображение', 'image'),
            Text::make('Название', 'name'),
            Text::make('Слаг', 'slug'),
            Text::make('Категория', formatted: static fn (Product $product) => $product->category?->name ?? 'Не выбрана'),
            Text::make('Бренд', formatted: static fn (Product $product) => $product->brand?->name ?? 'Не выбран'),
            Text::make('Цена', formatted: static fn (Product $product) => number_format((float) $product->price, 0, '.', ' ') . ' ₸'),
            Text::make('Флаги', formatted: static fn (Product $product) => implode(', ', array_filter([
                $product->new ? 'New' : null,
                $product->hit ? 'Hit' : null,
                $product->sale ? 'Sale' : null,
            ])) ?: 'Нет'),
            Textarea::make('Описание', 'content'),
        ];
    }

    public function filtersFields(): array
    {
        return [];
    }

    public function formRules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'regex:~^[-_a-z0-9]+$~i',
                Rule::unique('products', 'slug')->ignore($item->getKey()),
            ],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'content' => ['nullable', 'string'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png,webp'],
            'price' => ['required', 'numeric', 'min:1'],
            'new' => ['nullable', 'boolean'],
            'hit' => ['nullable', 'boolean'],
            'sale' => ['nullable', 'boolean'],
        ];
    }

    protected function search(): array
    {
        return ['id', 'name', 'slug', 'content', 'category.name', 'brand.name'];
    }

    protected function imageDirectory(): string
    {
        return 'product';
    }
}
