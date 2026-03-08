<?php

declare(strict_types=1);

namespace App\Services\Admin;

use DOMDocument;
use Illuminate\Support\Facades\Storage;

class PageContentManager
{
    public function prepare(string $content): string
    {
        return $this->sanitize($this->saveEmbeddedImages($content));
    }

    public function sanitize(string $content): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"/></head><body>'.$content.'</body></html>';
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $disallowedTags = ['script', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'meta', 'link', 'style'];

        foreach ($disallowedTags as $tag) {
            while (($nodes = $dom->getElementsByTagName($tag))->length > 0) {
                $node = $nodes->item(0);

                if ($node !== null && $node->parentNode !== null) {
                    $node->parentNode->removeChild($node);
                }
            }
        }

        $allowedTags = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'img', 'span', 'div'];
        $allowedAttributes = [
            'a' => ['href', 'title', 'target', 'rel'],
            'img' => ['src', 'alt', 'title', 'width', 'height'],
            '*' => ['class'],
        ];

        $nodes = [];

        foreach ($dom->getElementsByTagName('*') as $node) {
            $nodes[] = $node;
        }

        foreach ($nodes as $node) {
            $tagName = strtolower($node->nodeName);

            if (! in_array($tagName, $allowedTags, true)) {
                $parent = $node->parentNode;

                if ($parent === null) {
                    continue;
                }

                while ($node->firstChild) {
                    $parent->insertBefore($node->firstChild, $node);
                }

                $parent->removeChild($node);

                continue;
            }

            $tagAllowed = $allowedAttributes[$tagName] ?? [];
            $globalAllowed = $allowedAttributes['*'];
            $attributesToRemove = [];

            foreach ($node->attributes as $attribute) {
                $name = strtolower($attribute->name);
                $value = trim($attribute->value);
                $allowedForTag = in_array($name, $tagAllowed, true) || in_array($name, $globalAllowed, true);

                if (str_starts_with($name, 'on') || ! $allowedForTag) {
                    $attributesToRemove[] = $attribute->name;

                    continue;
                }

                if (($name === 'href' || $name === 'src') && ! $this->isSafeUrl($value, $tagName, $name)) {
                    $attributesToRemove[] = $attribute->name;
                }
            }

            foreach ($attributesToRemove as $attributeName) {
                $node->removeAttribute($attributeName);
            }

            if ($tagName === 'a' && $node->getAttribute('target') === '_blank') {
                $node->setAttribute('rel', 'noopener noreferrer');
            }
        }

        $body = $dom->getElementsByTagName('body')->item(0);

        if ($body === null) {
            return '';
        }

        $result = '';

        foreach ($body->childNodes as $child) {
            $result .= $dom->saveHTML($child);
        }

        return trim($result);
    }

    public function saveEmbeddedImages(string $content): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"/></head><body>'.$content.'</body></html>';
        @$dom->loadHTML($html);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $data = $img->getAttribute('src');

            if (! str_starts_with($data, 'data:image/')) {
                continue;
            }

            [$type, $encoded] = explode(';', $data, 2);
            [, $ext] = explode('/', $type, 2);
            [, $encoded] = explode(',', $encoded, 2);

            $binary = base64_decode($encoded, true);

            if ($binary === false) {
                continue;
            }

            $name = md5(uniqid((string) random_int(1, 999999), true)) . '.' . $ext;

            Storage::disk('public')->put('page/' . $name, $binary);

            $img->removeAttribute('data-filename');
            $img->setAttribute('src', Storage::disk('public')->url('page/' . $name));
        }

        $prepared = html_entity_decode($dom->saveXML($dom->documentElement));

        $prepared = str_replace(
            [
                '<html><head><meta charset="UTF-8"/></head><body>',
                '</body></html>',
            ],
            '',
            $prepared
        );

        return trim($prepared);
    }

    public function cleanup(string $content): void
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($content);

        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');

            if (! preg_match('~/storage/page/([0-9a-z]+\.(jpeg|jpg|png|gif|webp))~i', $src, $match)) {
                continue;
            }

            $name = $match[1];

            if (Storage::disk('public')->exists('page/' . $name)) {
                Storage::disk('public')->delete('page/' . $name);
            }
        }
    }

    private function isSafeUrl(string $value, string $tagName, string $attributeName): bool
    {
        if ($value === '' || str_starts_with($value, '#') || str_starts_with($value, '/')) {
            return true;
        }

        if ($attributeName === 'src'
            && $tagName === 'img'
            && preg_match('/^data:image\/(png|jpeg|jpg|gif|webp);base64,[a-z0-9+\/=]+$/i', $value)
        ) {
            return true;
        }

        return (bool) preg_match('/^(https?:|mailto:|tel:)/i', $value);
    }
}
