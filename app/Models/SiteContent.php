<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SiteContent extends Model
{
    protected $fillable = [
        'locale',
        'section',
        'label',
        'key',
        'value',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(static function (self $content): void {
            static::forgetTranslationCache($content->locale);
        });

        static::deleted(static function (self $content): void {
            static::forgetTranslationCache($content->locale);
        });
    }

    public function scopeForLocale(Builder $query, string $locale): Builder
    {
        return $query->where('locale', $locale);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('section')
            ->orderBy('sort_order')
            ->orderBy('key');
    }

    public function getDisplayLabelAttribute(): string
    {
        return $this->label ?: Str::headline(str_replace('.', ' ', $this->key));
    }

    public function getAdminSectionLabelAttribute(): string
    {
        return Str::headline(str_replace(['-', '_'], ' ', $this->section));
    }

    public function setLocaleAttribute(mixed $value): void
    {
        $this->attributes['locale'] = trim(mb_strtolower((string) $value));
    }

    public function setSectionAttribute(mixed $value): void
    {
        $this->attributes['section'] = trim(mb_strtolower((string) $value));
    }

    public function setLabelAttribute(mixed $value): void
    {
        $label = trim((string) $value);

        $this->attributes['label'] = $label === '' ? null : $label;
    }

    public function setKeyAttribute(mixed $value): void
    {
        $this->attributes['key'] = trim(mb_strtolower((string) $value));
    }

    public function setValueAttribute(mixed $value): void
    {
        $this->attributes['value'] = trim((string) $value);
    }

    public static function translationCacheKey(string $locale): string
    {
        return 'site_content.translations.'.$locale;
    }

    public static function forgetTranslationCache(?string $locale = null): void
    {
        $locales = $locale === null
            ? config('app.supported_locales', [config('app.locale', 'ru')])
            : [$locale];

        foreach ($locales as $targetLocale) {
            Cache::forget(static::translationCacheKey((string) $targetLocale));
        }
    }
}
