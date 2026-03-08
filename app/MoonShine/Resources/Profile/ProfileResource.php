<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Profile;

use Illuminate\Database\Eloquent\Model;
use App\Models\Profile;
use App\MoonShine\Resources\Profile\Pages\ProfileIndexPage;
use App\MoonShine\Resources\Profile\Pages\ProfileFormPage;
use App\MoonShine\Resources\Profile\Pages\ProfileDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Profile, ProfileIndexPage, ProfileFormPage, ProfileDetailPage>
 */
class ProfileResource extends ModelResource
{
    protected string $model = Profile::class;

    protected string $title = 'Profiles';
    
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ProfileIndexPage::class,
            ProfileFormPage::class,
            ProfileDetailPage::class,
        ];
    }
}
