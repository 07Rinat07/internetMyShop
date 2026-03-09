<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category;

use App\Models\Category;
use App\MoonShine\Resources\Category\Pages\CategoryDetailPage;
use App\MoonShine\Resources\Category\Pages\CategoryFormPage;
use App\MoonShine\Resources\Category\Pages\CategoryIndexPage;
use App\MoonShine\Resources\Support\CatalogModelResource;
use App\Rules\CategoryParent;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use RuntimeException;

/**
 * @extends CatalogModelResource<Category, CategoryIndexPage, CategoryFormPage, CategoryDetailPage>
 */
class CategoryResource extends CatalogModelResource
{
    protected string $model = Category::class;

    protected string $title = '';

    protected string $column = 'name';

    protected string $sortColumn = 'name';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected int $itemsPerPage = 20;

    protected function onBoot(): void
    {
        $this->title = __('admin.resources.category.title');
        $this->alias('categories');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CategoryIndexPage::class,
            CategoryFormPage::class,
            CategoryDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            $this->previewField(__('admin.fields.photo'))->columnSelection(false),
            Text::make(__('admin.fields.name'), 'name')->sortable(),
            Text::make(__('admin.fields.slug'), 'slug'),
            Text::make(__('admin.fields.parent'), formatted: static fn (Category $category) => $category->parent?->name ?? __('admin.common.root_category')),
            Text::make(__('admin.fields.products_count'), formatted: static fn (Category $category) => (string) $category->products()->count()),
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
                Select::make(__('admin.resources.category.parent_category'), 'parent_id')
                    ->options($this->parentOptions((int) ($this->getItem()?->id ?? 0)))
                    ->default(0)
                    ->required(),
                Textarea::make(__('admin.fields.description'), 'content')->nullable(),
                $this->uploadField(),
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
            Text::make(__('admin.fields.parent'), formatted: static fn (Category $category) => $category->parent?->name ?? __('admin.common.root_category')),
            Text::make(__('admin.fields.products_count'), formatted: static fn (Category $category) => (string) $category->products()->count()),
            Textarea::make(__('admin.fields.description'), 'content'),
        ];
    }

    public function filtersFields(): array
    {
        return [];
    }

    public function formRules(DataWrapperContract $item): array
    {
        $current = $item->getOriginal();

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'regex:~^[-_a-z0-9]+$~i',
                Rule::unique('categories', 'slug')->ignore($item->getKey()),
            ],
            'parent_id' => ['required', 'regex:~^[0-9]+$~'],
            'content' => ['nullable', 'string', 'max:200'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png,webp'],
        ];

        if ($current->exists) {
            $rules['parent_id'][] = new CategoryParent($current);
        }

        return $rules;
    }

    protected function search(): array
    {
        return ['id', 'name', 'slug', 'content'];
    }

    protected function imageDirectory(): string
    {
        return 'category';
    }

    protected function beforeDeleting(DataWrapperContract $item): DataWrapperContract
    {
        $category = $item->getOriginal();

        if ($category->children()->exists()) {
            throw new RuntimeException(__('admin.resources.category.cannot_delete_with_children'));
        }

        if ($category->products()->exists()) {
            throw new RuntimeException(__('admin.resources.category.cannot_delete_with_products'));
        }

        return parent::beforeDeleting($item);
    }

    private function parentOptions(int $currentId = 0): array
    {
        $excluded = $currentId > 0 ? Category::getAllChildren($currentId) : [];

        if ($currentId > 0) {
            $excluded[] = $currentId;
        }

        return [0 => __('admin.common.root_category')] + Category::query()
            ->when($excluded !== [], static fn ($query) => $query->whereNotIn('id', $excluded))
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }
}
