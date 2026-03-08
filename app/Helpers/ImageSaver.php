<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageSaver {
    /**
     * Сохраняет изображение при создании или редактировании категории,
     * бренда или товара; создает два уменьшенных изображения.
     *
     * @param \Illuminate\Http\Request $request — объект HTTP-запроса
     * @param \App\Models\Item $item — модель категории, бренда или товара
     * @param string $dir — директория, куда будем сохранять изображение
     * @return string|null — имя файла изображения для сохранения в БД
     */
    public function upload($request, $item, $dir) {
        $name = $item->image ?? null;
        if ($item && $request->remove) { // если надо удалить изображение
            $this->remove($item, $dir);
            $name = null;
        }
        $source = $request->file('image');
        if ($source) { // если было загружено изображение
            // перед загрузкой нового изображения удаляем старое
            if ($item && $item->image) {
                $this->remove($item, $dir);
            }
            $ext = $source->extension();
            // сохраняем загруженное изображение без всяких изменений
            $path = $source->store('catalog/'.$dir.'/source', 'public');
            $path = Storage::disk('public')->path($path); // абсолютный путь
            $name = basename($path); // имя файла
            // создаем уменьшенное изображение 600x300px, качество 100%
            $dst = 'catalog/'.$dir.'/image/';
            $this->resize($path, $dst, 600, 300, $ext);
            // создаем уменьшенное изображение 300x150px, качество 100%
            $dst = 'catalog/'.$dir.'/thumb/';
            $this->resize($path, $dst, 300, 150, $ext);
        }
        return $name;
    }

    /**
     * Создает уменьшенную копию изображения
     *
     * @param string $src — путь к исходному изображению
     * @param string $dst — куда сохранять уменьшенное
     * @param integer $width — ширина в пикселях
     * @param integer $height — высота в пикселях
     * @param string $ext — расширение уменьшенного
     */
    private function resize($src, $dst, $width, $height, $ext) {
        // создаем уменьшенное изображение width x height, качество 100%
        $image = Image::read($src)
            ->scale(height: $height)
            ->resizeCanvas(width: $width, height: $height, background: 'eeeeee');
        // сохраняем это изображение под тем же именем, что исходное
        $name = basename($src);
        Storage::disk('public')->put(
            $dst . $name,
            (string)$image->encodeByExtension($ext, quality: 100)
        );
    }

    /**
     * Удаляет изображение при удалении категории, бренда или товара
     *
     * @param \App\Models\Item $item — модель категории, бренда или товара
     * @param string $dir — директория, в которой находится изображение
     */
    public function remove($item, $dir) {
        $old = $item->image;
        if ($old) {
            $this->removeByName($old, $dir);
        }
    }

    /**
     * Удаляет изображения по имени файла.
     */
    public function removeByName(?string $name, string $dir): void
    {
        if (empty($name)) {
            return;
        }

        $name = basename($name);

        Storage::disk('public')->delete('catalog/'.$dir.'/source/' . $name);
        Storage::disk('public')->delete('catalog/'.$dir.'/image/' . $name);
        Storage::disk('public')->delete('catalog/'.$dir.'/thumb/' . $name);
    }

    /**
     * Доводит загруженный MoonShine файл до формата проекта:
     * в БД остается basename, а на диске создаются image/thumb.
     */
    public function syncMoonShineUpload(Model $item, string $dir, ?string $previousImage = null): void
    {
        $currentImage = $item->image;
        $previousImage = empty($previousImage) ? null : basename($previousImage);

        if (empty($currentImage)) {
            if ($previousImage !== null) {
                $this->removeByName($previousImage, $dir);
            }

            return;
        }

        $rawPath = (string) $currentImage;
        $basename = basename($rawPath);

        if ($previousImage !== null && $previousImage !== $basename) {
            $this->removeByName($previousImage, $dir);
        }

        $sourcePath = str_contains($rawPath, '/')
            ? $rawPath
            : 'catalog/'.$dir.'/source/'.$basename;

        if (! Storage::disk('public')->exists($sourcePath)) {
            $item->forceFill(['image' => $basename])->saveQuietly();

            return;
        }

        if (str_contains($rawPath, '/')
            || ! Storage::disk('public')->exists('catalog/'.$dir.'/image/'.$basename)
            || ! Storage::disk('public')->exists('catalog/'.$dir.'/thumb/'.$basename)
        ) {
            $absolutePath = Storage::disk('public')->path($sourcePath);
            $ext = pathinfo($basename, PATHINFO_EXTENSION) ?: 'jpg';

            $this->resize($absolutePath, 'catalog/'.$dir.'/image/', 600, 300, $ext);
            $this->resize($absolutePath, 'catalog/'.$dir.'/thumb/', 300, 150, $ext);
        }

        if ($item->image !== $basename) {
            $item->forceFill(['image' => $basename])->saveQuietly();
        }
    }
}
