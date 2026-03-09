<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\SiteContent;

use App\Models\SiteContent;
use App\MoonShine\Resources\SiteContent\Pages\SiteContentDetailPage;
use App\MoonShine\Resources\SiteContent\Pages\SiteContentFormPage;
use App\MoonShine\Resources\SiteContent\Pages\SiteContentIndexPage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<SiteContent, SiteContentIndexPage, SiteContentFormPage, SiteContentDetailPage>
 */
class SiteContentResource extends ModelResource
{
    protected string $model = SiteContent::class;

    protected string $title = '';

    protected string $column = 'label';

    protected string $sortColumn = 'section';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected int $itemsPerPage = 25;

    protected function onBoot(): void
    {
        $this->title = __('admin.resources.site_content.title');
        $this->alias('site-content');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            SiteContentIndexPage::class,
            SiteContentFormPage::class,
            SiteContentDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make(__('admin.fields.locale'), 'locale')->sortable(),
            Text::make(__('admin.fields.section'), formatted: static fn (SiteContent $content) => $content->admin_section_label)->sortable('section'),
            Text::make(__('admin.fields.label'), formatted: static fn (SiteContent $content) => $content->display_label)->sortable('label'),
            Text::make(__('admin.fields.key'), 'key')->sortable(),
            Text::make(
                __('admin.fields.value'),
                formatted: static fn (SiteContent $content) => mb_strimwidth(
                    preg_replace('/\s+/u', ' ', trim($content->value)) ?? '',
                    0,
                    120,
                    '...'
                )
            ),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Flex::make([
                    Select::make(__('admin.fields.locale'), 'locale')
                        ->options($this->localeOptions())
                        ->default((string) config('app.locale', 'ru'))
                        ->required(),
                    Text::make(__('admin.fields.section'), 'section')
                        ->required()
                        ->customAttributes(['placeholder' => __('admin.resources.site_content.section_placeholder')]),
                ]),
                Flex::make([
                    Text::make(__('admin.fields.label'), 'label')
                        ->required()
                        ->customAttributes(['placeholder' => __('admin.resources.site_content.label_placeholder')]),
                    Text::make(__('admin.fields.key'), 'key')
                        ->required()
                        ->customAttributes(['placeholder' => __('admin.resources.site_content.key_placeholder')]),
                ]),
                Number::make(__('admin.fields.sort_order'), 'sort_order')
                    ->min(0)
                    ->step(1)
                    ->default(0),
                Textarea::make(__('admin.fields.value'), 'value')
                    ->required()
                    ->customAttributes([
                        'rows' => 6,
                        'placeholder' => __('admin.resources.site_content.value_placeholder'),
                    ]),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Text::make(__('admin.fields.locale'), 'locale'),
            Text::make(__('admin.fields.section'), formatted: static fn (SiteContent $content) => $content->admin_section_label),
            Text::make(__('admin.fields.label'), formatted: static fn (SiteContent $content) => $content->display_label),
            Text::make(__('admin.fields.key'), 'key'),
            Number::make(__('admin.fields.sort_order'), 'sort_order'),
            Textarea::make(__('admin.fields.value'), 'value'),
            Text::make(__('admin.fields.usage'), formatted: static fn (SiteContent $content) => "__('site.{$content->key}')"),
        ];
    }

    public function filtersFields(): array
    {
        return [];
    }

    public function formRules(DataWrapperContract $item): array
    {
        $locale = (string) request()->input(
            'locale',
            $item->getOriginal()?->locale ?? config('app.locale', 'ru')
        );

        return [
            'locale' => ['required', 'string', Rule::in(config('app.supported_locales', ['ru']))],
            'section' => ['required', 'string', 'max:50', 'regex:~^[a-z0-9_-]+$~i'],
            'label' => ['required', 'string', 'max:150'],
            'key' => [
                'required',
                'string',
                'max:150',
                'regex:~^[a-z0-9._-]+$~i',
                Rule::unique('site_contents', 'key')
                    ->where(static fn ($query) => $query->where('locale', $locale))
                    ->ignore($item->getKey()),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'value' => ['required', 'string'],
        ];
    }

    protected function search(): array
    {
        return ['id', 'locale', 'section', 'label', 'key', 'value'];
    }

    /**
     * @return array<string, string>
     */
    private function localeOptions(): array
    {
        return collect(config('app.supported_locales', ['ru']))
            ->mapWithKeys(static fn (string $locale): array => [
                $locale => Str::upper($locale).' - '.match ($locale) {
                    'ru' => __('admin.common.russian'),
                    'en' => __('admin.common.english'),
                    default => Str::headline($locale),
                },
            ])
            ->all();
    }
}
