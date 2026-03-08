<?php

namespace App\Services\SiteContent;

use App\Models\SiteContent;
use App\Support\SiteContentDefaults;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteContentService
{
    public function applyTranslations(?string $locale = null): void
    {
        if (! $this->tableExists()) {
            return;
        }

        $translator = app('translator');

        foreach ($this->localesFor($locale) as $targetLocale) {
            $lines = $this->translationLinesFor($targetLocale);

            if ($lines === []) {
                continue;
            }

            $translator->get('site', [], $targetLocale);
            $translator->addLines($lines, $targetLocale);
        }
    }

    public function syncDefaults(): void
    {
        if (! $this->tableExists()) {
            return;
        }

        foreach (SiteContentDefaults::entries() as $entry) {
            SiteContent::query()->firstOrCreate(
                [
                    'locale' => $entry['locale'],
                    'key' => $entry['key'],
                ],
                $entry,
            );
        }
    }

    /**
     * @return array<int, string>
     */
    private function localesFor(?string $locale = null): array
    {
        return array_values(array_unique(array_filter([
            $locale ?: app()->getLocale(),
            config('app.fallback_locale'),
        ])));
    }

    private function tableExists(): bool
    {
        return Schema::hasTable('site_contents');
    }

    /**
     * @return array<string, string>
     */
    private function translationLinesFor(string $locale): array
    {
        $resolver = static function () use ($locale): array {
            return SiteContent::query()
                ->forLocale($locale)
                ->ordered()
                ->pluck('value', 'key')
                ->mapWithKeys(static fn (string $value, string $key): array => ['site.'.$key => $value])
                ->all();
        };

        if (app()->runningUnitTests()) {
            return $resolver();
        }

        return Cache::remember(
            SiteContent::translationCacheKey($locale),
            now()->addMinutes(10),
            $resolver,
        );
    }
}
