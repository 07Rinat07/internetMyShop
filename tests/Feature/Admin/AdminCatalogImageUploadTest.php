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
                'image' => UploadedFile::fake()->image('tect.jpg', 1600, 900),
            ]);

        $response->assertRedirect();

        $brand = Brand::query()->where('slug', 'tect')->firstOrFail();

        $this->assertNotNull($brand->image);
        $this->assertSame(basename($brand->image), $brand->image);

        Storage::disk('public')->assertExists('catalog/brand/source/'.$brand->image);
        Storage::disk('public')->assertExists('catalog/brand/image/'.$brand->image);
        Storage::disk('public')->assertExists('catalog/brand/thumb/'.$brand->image);
    }
}
