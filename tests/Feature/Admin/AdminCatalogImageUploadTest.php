<?php

namespace Tests\Feature\Admin;

use App\Models\Brand;
use App\Models\User;
use App\MoonShine\Resources\Brand\BrandResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCatalogImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_brand_with_uploaded_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['admin' => true]);

        $response = $this
            ->actingAs($admin)
            ->post(route('moonshine.crud.store', [
                'resourceUri' => app(BrandResource::class)->getUriKey(),
            ]), [
                'name' => 'Tect',
                'slug' => 'tect',
                'content' => 'Brand with uploaded image',
                'image' => $this->fixtureImage(),
            ]);

        $response->assertRedirect();

        $brand = Brand::query()->where('slug', 'tect')->firstOrFail();

        $this->assertNotNull($brand->image);
        $this->assertSame(basename($brand->image), $brand->image);

        Storage::disk('public')->assertExists('catalog/brand/source/'.$brand->image);
        Storage::disk('public')->assertExists('catalog/brand/image/'.$brand->image);
        Storage::disk('public')->assertExists('catalog/brand/thumb/'.$brand->image);
    }

    private function fixtureImage(): UploadedFile
    {
        $directory = storage_path('framework/testing/fixtures');

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $path = $directory.'/tect.png';
        $image = imagecreatetruecolor(16, 16);

        if ($image === false) {
            throw new \RuntimeException('Failed to create GD test image.');
        }

        imagealphablending($image, true);
        $background = imagecolorallocate($image, 24, 93, 169);
        imagefilledrectangle($image, 0, 0, 15, 15, $background);
        imagepng($image, $path);
        imagedestroy($image);

        return new UploadedFile($path, 'tect.png', 'image/png', null, true);
    }
}
