<?php

namespace App\Support;

use Illuminate\Support\Str;

class SiteContentDefaults
{
    /**
     * @return array<int, array{locale: string, section: string, label: string, key: string, value: string, sort_order: int}>
     */
    public static function entries(): array
    {
        $entries = [];

        foreach (config('app.supported_locales', [config('app.locale', 'ru')]) as $locale) {
            $translations = require lang_path($locale.'/site.php');
            $index = 0;

            foreach (self::flatten($translations) as $key => $value) {
                $entries[] = [
                    'locale' => (string) $locale,
                    'section' => Str::before($key, '.'),
                    'label' => self::makeLabel($key),
                    'key' => $key,
                    'value' => $value,
                    'sort_order' => $index++,
                ];
            }
        }

        return $entries;
    }

    /**
     * @param  array<string, mixed>  $items
     * @return array<string, string>
     */
    private static function flatten(array $items, string $prefix = ''): array
    {
        $result = [];

        foreach ($items as $key => $value) {
            $currentKey = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                $result += self::flatten($value, $currentKey);

                continue;
            }

            if (is_string($value)) {
                $result[$currentKey] = $value;
            }
        }

        return $result;
    }

    private static function makeLabel(string $key): string
    {
        [$section, $rest] = array_pad(explode('.', $key, 2), 2, '');

        $sectionLabel = self::sectionLabels()[$section] ?? Str::headline($section);
        $restLabel = $rest === ''
            ? $sectionLabel
            : Str::headline(str_replace(['.', '_'], ' ', $rest));

        return $rest === '' ? $sectionLabel : $sectionLabel.': '.$restLabel;
    }

    /**
     * @return array<string, string>
     */
    private static function sectionLabels(): array
    {
        return [
            'meta' => 'Meta',
            'header' => 'Header',
            'navigation' => 'Navigation',
            'footer' => 'Footer',
            'sidebar' => 'Sidebar',
            'home' => 'Home',
            'catalog' => 'Catalog',
            'product' => 'Product',
            'filters' => 'Filters',
            'basket' => 'Basket',
            'table' => 'Table',
            'forms' => 'Forms',
            'account' => 'Account',
            'page' => 'Page',
            'errors' => 'Errors',
            'messages' => 'Messages',
            'order_status' => 'Order Status',
        ];
    }
}
