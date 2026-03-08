<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;

/**
 * @extends DetailPage<\App\MoonShine\Resources\User\UserResource>
 */
final class UserDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return $this->getResource()->detailFields();
    }
}
