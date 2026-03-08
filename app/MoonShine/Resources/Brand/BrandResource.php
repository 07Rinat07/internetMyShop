<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Brand;

use App\Models\Brand;
use App\MoonShine\Resources\Brand\Pages\BrandDetailPage;
use App\MoonShine\Resources\Brand\Pages\BrandFormPage;
use App\MoonShine\Resources\Brand\Pages\BrandIndexPage;
use App\MoonShine\Resources\Support\CatalogModelResource;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use RuntimeException;

/**
 * @extends CatalogModelResource<Brand, BrandIndexPage, BrandFormPage, BrandDetailPage>
 */
class BrandResource extends CatalogModelResource
{
    protected string $model = Brand::class;

    protected string $title = 'Бренды';

    protected string $column = 'name';

    protected string $sortColumn = 'name';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected function onBoot(): void
    {
        $this->alias('brands');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            BrandIndexPage::class,
            BrandFormPage::class,
            BrandDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            $this->previewField('Фото')->columnSelection(false),
            Text::make('Название', 'name')->sortable(),
            Text::make('Слаг', 'slug'),
            Text::make('Товаров', formatted: static fn (Brand $brand) => (string) $brand->products()->count()),
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
                Textarea::make('Описание', 'content')->nullable(),
                $this->uploadField(),
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
            Text::make('Товаров', formatted: static fn (Brand $brand) => (string) $brand->products()->count()),
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
                Rule::unique('brands', 'slug')->ignore($item->getKey()),
            ],
            'content' => ['nullable', 'string', 'max:200'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png,webp'],
        ];
    }

    protected function search(): array
    {
        return ['id', 'name', 'slug', 'content'];
    }

    protected function imageDirectory(): string
    {
        return 'brand';
    }

    protected function beforeDeleting(DataWrapperContract $item): DataWrapperContract
    {
        if ($item->getOriginal()->products()->exists()) {
            throw new RuntimeException('Нельзя удалить бренд, у которого есть товары');
        }

        return parent::beforeDeleting($item);
    }
}
