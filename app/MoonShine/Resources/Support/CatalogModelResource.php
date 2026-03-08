<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Support;

use App\Helpers\ImageSaver;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\Image;

abstract class CatalogModelResource extends ModelResource
{
    private ?string $previousImage = null;

    abstract protected function imageDirectory(): string;

    public function uploadField(string $label = 'Изображение'): Image
    {
        return Image::make($label, 'image')
            ->disk('public')
            ->dir('catalog/'.$this->imageDirectory().'/source')
            ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
            ->disableDeleteFiles()
            ->removable()
            ->modifyRawValue(static fn (?string $raw): string => $raw ?? '');
    }

    public function previewField(string $label = 'Изображение', string $variant = 'thumb'): Image
    {
        return Image::make($label, 'image')
            ->disk('public')
            ->dir('catalog/'.$this->imageDirectory().'/'.$variant)
            ->modifyRawValue(static fn (?string $raw): string => $raw ?? '');
    }

    protected function beforeCreating(DataWrapperContract $item): DataWrapperContract
    {
        $this->previousImage = null;

        return parent::beforeCreating($item);
    }

    protected function beforeUpdating(DataWrapperContract $item): DataWrapperContract
    {
        $this->previousImage = $item->getOriginal()->getOriginal('image') ?: $item->getOriginal()->image;

        return parent::beforeUpdating($item);
    }

    protected function afterCreated(DataWrapperContract $item): DataWrapperContract
    {
        app(ImageSaver::class)->syncMoonShineUpload(
            $item->getOriginal(),
            $this->imageDirectory(),
            $this->previousImage
        );

        $this->previousImage = null;

        return parent::afterCreated($item);
    }

    protected function afterUpdated(DataWrapperContract $item): DataWrapperContract
    {
        app(ImageSaver::class)->syncMoonShineUpload(
            $item->getOriginal(),
            $this->imageDirectory(),
            $this->previousImage
        );

        $this->previousImage = null;

        return parent::afterUpdated($item);
    }

    protected function beforeDeleting(DataWrapperContract $item): DataWrapperContract
    {
        app(ImageSaver::class)->removeByName(
            $item->getOriginal()->image,
            $this->imageDirectory()
        );

        return parent::beforeDeleting($item);
    }
}
