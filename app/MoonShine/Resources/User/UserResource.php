<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User;

use App\Models\User;
use App\MoonShine\Resources\User\Pages\UserDetailPage;
use App\MoonShine\Resources\User\Pages\UserFormPage;
use App\MoonShine\Resources\User\Pages\UserIndexPage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<User, UserIndexPage, UserFormPage, UserDetailPage>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Пользователи';

    protected string $column = 'name';

    protected string $sortColumn = 'created_at';

    protected SortDirection $sortDirection = SortDirection::DESC;

    protected function onBoot(): void
    {
        $this->alias('users');
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            UserIndexPage::class,
            UserFormPage::class,
            UserDetailPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name')->sortable(),
            Email::make('Email', 'email')->sortable(),
            Text::make('Роль', formatted: static fn (User $user) => $user->isAdmin() ? 'Администратор' : 'Пользователь'),
            Date::make('Зарегистрирован', 'created_at')->format('d.m.Y H:i')->sortable(),
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make(),
                Flex::make([
                    Text::make('Имя', 'name')->required(),
                    Email::make('Email', 'email')->required(),
                ]),
                Switcher::make('Администратор', 'admin'),
                Date::make('Зарегистрирован', 'created_at')->format('d.m.Y H:i')->default(now()->toDateTimeString())->previewMode(),
                Collapse::make('Смена пароля', [
                    Password::make('Пароль', 'password')
                        ->customAttributes(['autocomplete' => 'new-password'])
                        ->eye(),
                    PasswordRepeat::make('Повтор пароля', 'password_confirmation')
                        ->customAttributes(['autocomplete' => 'confirm-password'])
                        ->eye(),
                ]),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Text::make('Имя', 'name'),
            Email::make('Email', 'email'),
            Text::make('Роль', formatted: static fn (User $user) => $user->isAdmin() ? 'Администратор' : 'Пользователь'),
            Date::make('Зарегистрирован', 'created_at')->format('d.m.Y H:i'),
        ];
    }

    public function filtersFields(): array
    {
        return [];
    }

    public function formRules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($item->getKey()),
            ],
            'admin' => ['nullable', 'boolean'],
            'password' => [
                ...$item->getKey() !== null ? ['sometimes', 'nullable'] : ['required'],
                PasswordRule::defaults(),
                'confirmed',
            ],
        ];
    }

    protected function activeActions(): ListOf
    {
        return new ListOf(Action::class, [
            Action::VIEW,
            Action::UPDATE,
        ]);
    }

    protected function search(): array
    {
        return ['id', 'name', 'email'];
    }
}
