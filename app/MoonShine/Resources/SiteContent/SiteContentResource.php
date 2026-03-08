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

    protected string $title = 'Контент витрины';

    protected string $column = 'label';

    protected string $sortColumn = 'section';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected int $itemsPerPage = 25;

    protected function onBoot(): void
    {
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
            Text::make('Локаль', 'locale')->sortable(),
            Text::make('Секция', formatted: static fn (SiteContent $content) => $content->admin_section_label)->sortable('section'),
            Text::make('Название', formatted: static fn (SiteContent $content) => $content->display_label)->sortable('label'),
            Text::make('Ключ', 'key')->sortable(),
            Text::make(
                'Значение',
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
                    Select::make('Локаль', 'locale')
                        ->options($this->localeOptions())
                        ->default((string) config('app.locale', 'ru'))
                        ->required(),
                    Text::make('Секция', 'section')
                        ->required()
                        ->customAttributes(['placeholder' => 'header']),
                ]),
                Flex::make([
                    Text::make('Название', 'label')
                        ->required()
                        ->customAttributes(['placeholder' => 'Header: Brand']),
                    Text::make('Ключ', 'key')
                        ->required()
                        ->customAttributes(['placeholder' => 'header.brand']),
                ]),
                Number::make('Порядок', 'sort_order')
                    ->min(0)
                    ->step(1)
                    ->default(0),
                Textarea::make('Значение', 'value')
                    ->required()
                    ->customAttributes([
                        'rows' => 6,
                        'placeholder' => 'Текст для витрины',
                    ]),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Text::make('Локаль', 'locale'),
            Text::make('Секция', formatted: static fn (SiteContent $content) => $content->admin_section_label),
            Text::make('Название', formatted: static fn (SiteContent $content) => $content->display_label),
            Text::make('Ключ', 'key'),
            Number::make('Порядок', 'sort_order'),
            Textarea::make('Значение', 'value'),
            Text::make('Использование', formatted: static fn (SiteContent $content) => "__('site.{$content->key}')"),
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
                    'ru' => 'Русский',
                    'en' => 'English',
                    default => Str::headline($locale),
                },
            ])
            ->all();
    }
}
