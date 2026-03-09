<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page;

use App\Models\Page;
use App\MoonShine\Resources\Page\Pages\PageDetailPage;
use App\MoonShine\Resources\Page\Pages\PageFormPage;
use App\MoonShine\Resources\Page\Pages\PageIndexPage;
use App\Services\Admin\PageContentManager;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use RuntimeException;

/**
 * @extends ModelResource<Page, PageIndexPage, PageFormPage, PageDetailPage>
 */
class PageResource extends ModelResource
{
    protected string $model = Page::class;

    protected string $title = '';

    protected string $column = 'name';

    protected string $sortColumn = 'name';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected function onBoot(): void
    {
        $this->title = __('admin.resources.page.title');
        $this->alias('pages');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PageIndexPage::class,
            PageFormPage::class,
            PageDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('admin.fields.name'), 'name')->sortable(),
            Text::make(__('admin.fields.slug'), 'slug'),
            Text::make(__('admin.fields.parent'), formatted: static fn (Page $page) => $page->parent?->name ?? __('admin.common.root_page')),
            Text::make(__('admin.fields.content'), formatted: static fn (Page $page) => mb_strimwidth(trim(strip_tags((string) $page->content)), 0, 120, '...')),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Flex::make([
                    Text::make(__('admin.fields.name'), 'name')->required(),
                    Text::make(__('admin.fields.slug'), 'slug')->required(),
                ]),
                Select::make(__('admin.resources.page.parent_page'), 'parent_id')
                    ->options($this->parentOptions((int) ($this->getItem()?->id ?? 0)))
                    ->default(0)
                    ->required(),
                Textarea::make(__('admin.fields.content'), 'content')
                    ->unescape()
                    ->required()
                    ->onApply(static function (Page $page, mixed $value): Page {
                        $page->content = app(PageContentManager::class)->prepare((string) $value);

                        return $page;
                    }),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Text::make(__('admin.fields.name'), 'name'),
            Text::make(__('admin.fields.slug'), 'slug'),
            Text::make(__('admin.fields.parent'), formatted: static fn (Page $page) => $page->parent?->name ?? __('admin.common.root_page')),
            Textarea::make(__('admin.fields.content'), 'content')->unescape(),
        ];
    }

    public function filtersFields(): array
    {
        return [];
    }

    public function formRules(DataWrapperContract $item): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'parent_id' => ['required', 'regex:~^[0-9]+$~'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'regex:~^[-_a-z0-9]+$~i',
                Rule::unique('pages', 'slug')->ignore($item->getKey()),
            ],
            'content' => ['required', 'string'],
        ];

        if ($item->getKey() !== null) {
            $rules['parent_id'][] = 'not_in:' . $item->getKey();
        }

        return $rules;
    }

    protected function search(): array
    {
        return ['id', 'name', 'slug', 'content'];
    }

    protected function beforeDeleting(DataWrapperContract $item): DataWrapperContract
    {
        $page = $item->getOriginal();

        if ($page->children()->exists()) {
            throw new RuntimeException(__('admin.resources.page.cannot_delete_with_children'));
        }

        app(PageContentManager::class)->cleanup((string) $page->content);

        return parent::beforeDeleting($item);
    }

    private function parentOptions(int $currentId = 0): array
    {
        return [0 => __('admin.common.root_page')] + Page::query()
            ->where('parent_id', 0)
            ->when($currentId > 0, static fn ($query) => $query->whereKeyNot($currentId))
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }
}
