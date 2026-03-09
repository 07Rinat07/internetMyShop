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

    protected string $title = '';

    protected string $column = 'name';

    protected string $sortColumn = 'created_at';

    protected SortDirection $sortDirection = SortDirection::DESC;

    protected int $itemsPerPage = 15;

    protected array $with = ['category', 'brand'];

    protected function onBoot(): void
    {
        $this->title = __('admin.resources.product.title');
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
            $this->previewField(__('admin.fields.photo'))->columnSelection(false),
            Text::make(__('admin.fields.name'), 'name')->sortable(),
            Text::make(__('admin.fields.slug'), 'slug'),
            Text::make(__('admin.fields.category'), formatted: static fn (Product $product) => $product->category?->name ?? __('admin.common.not_selected')),
            Text::make(__('admin.fields.brand'), formatted: static fn (Product $product) => $product->brand?->name ?? __('admin.common.not_selected')),
            Text::make(__('admin.fields.price'), formatted: static fn (Product $product) => number_format((float) $product->price, 0, '.', ' ') . ' ₸')->sortable('price'),
            Text::make(__('admin.fields.flags'), formatted: static fn (Product $product) => implode(', ', array_filter([
                $product->new ? __('admin.fields.new') : null,
                $product->hit ? __('admin.fields.hit') : null,
                $product->sale ? __('admin.fields.sale') : null,
            ])) ?: __('admin.common.none')),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Flex::make([
                    Text::make(__('admin.fields.name'), 'name')->required(),
                    Slug::make(__('admin.fields.slug'), 'slug')->from('name')->live(),
                ]),
                Flex::make([
                    BelongsTo::make(
                        __('admin.fields.category'),
                        'category',
                        formatted: static fn (Category $category) => $category->name,
                        resource: CategoryResource::class,
                    )->valuesQuery(static fn (Builder $query) => $query->select(['id', 'name']))->required(),
                    BelongsTo::make(
                        __('admin.fields.brand'),
                        'brand',
                        formatted: static fn (Brand $brand) => $brand->name,
                        resource: BrandResource::class,
                    )->valuesQuery(static fn (Builder $query) => $query->select(['id', 'name']))->required(),
                ]),
                Textarea::make(__('admin.fields.description'), 'content')->nullable(),
                $this->uploadField(),
                Number::make(__('admin.fields.price'), 'price')->min(1)->step(1)->required(),
                Flex::make([
                    Switcher::make(__('admin.fields.new'), 'new'),
                    Switcher::make(__('admin.fields.hit'), 'hit'),
                    Switcher::make(__('admin.fields.sale'), 'sale'),
                ]),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            $this->previewField(__('admin.fields.image'), 'image'),
            Text::make(__('admin.fields.name'), 'name'),
            Text::make(__('admin.fields.slug'), 'slug'),
            Text::make(__('admin.fields.category'), formatted: static fn (Product $product) => $product->category?->name ?? __('admin.common.not_selected')),
            Text::make(__('admin.fields.brand'), formatted: static fn (Product $product) => $product->brand?->name ?? __('admin.common.not_selected')),
            Text::make(__('admin.fields.price'), formatted: static fn (Product $product) => number_format((float) $product->price, 0, '.', ' ') . ' ₸'),
            Text::make(__('admin.fields.flags'), formatted: static fn (Product $product) => implode(', ', array_filter([
                $product->new ? __('admin.fields.new') : null,
                $product->hit ? __('admin.fields.hit') : null,
                $product->sale ? __('admin.fields.sale') : null,
            ])) ?: __('admin.common.none')),
            Textarea::make(__('admin.fields.description'), 'content'),
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
