<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page\Pages;

use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\DetailPage;

/**
 * @extends DetailPage<\App\MoonShine\Resources\Page\PageResource>
 */
final class PageDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return $this->getResource()->detailFields();
    }
}
