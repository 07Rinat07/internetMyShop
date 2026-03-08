<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Order\Pages;

use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;

/**
 * @extends FormPage<\App\MoonShine\Resources\Order\OrderResource>
 */
final class OrderFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return $this->getResource()->formFields();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return $this->getResource()->formRules($item);
    }
}
