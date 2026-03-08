<?php

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\Administrator;
use App\Models\User;
use App\MoonShine\Pipelines\EnsureMoonShineAdminLogin;
use MoonShine\ColorManager\Palettes\GreenPalette;
use MoonShine\Crud\Forms\FiltersForm;
use MoonShine\Crud\Forms\LoginForm;
use MoonShine\Laravel\Exceptions\MoonShineNotFoundException;
use MoonShine\Laravel\Http\Middleware\Authenticate;
use MoonShine\Laravel\Http\Middleware\ChangeLocale;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Pages\Dashboard;
use MoonShine\Laravel\Pages\ErrorPage;
use MoonShine\Laravel\Pages\LoginPage;
use MoonShine\Laravel\Pages\ProfilePage;

return [
    'title' => env('MOONSHINE_TITLE', 'InternetMyShop Admin'),
    'logo' => '/vendor/moonshine/logo-small.svg',
    'logo_small' => '/vendor/moonshine/logo-small.svg',

    'favicons' => [
        'apple-touch' => '/vendor/moonshine/apple-touch-icon.png',
        '32' => '/vendor/moonshine/favicon-32x32.png',
        '16' => '/vendor/moonshine/favicon-16x16.png',
        'safari-pinned-tab' => '/vendor/moonshine/safari-pinned-tab.svg',
    ],

    // Default flags
    'use_migrations' => true,
    'use_notifications' => false,
    'use_database_notifications' => false,
    'use_routes' => true,
    'use_profile' => false,

    // Routing
    'domain' => env('MOONSHINE_DOMAIN'),
    'prefix' => env('MOONSHINE_ROUTE_PREFIX', 'admin'),
    'page_prefix' => env('MOONSHINE_PAGE_PREFIX', 'page'),
    'resource_prefix' => env('MOONSHINE_RESOURCE_PREFIX', 'resource'),
    'home_route' => 'moonshine.index',

    // Error handling
    'not_found_exception' => MoonShineNotFoundException::class,

    // Middleware
    'middleware' => [
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        AuthenticateSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
        SubstituteBindings::class,
        ChangeLocale::class,
    ],

    // Storage
    'disk' => 'public',
    'disk_options' => [],
    'cache' => 'file',

    // Authentication and profile
    'auth' => [
        'enabled' => true,
        'guard' => 'web',
        'model' => User::class,
        'middleware' => [
            Authenticate::class,
            Administrator::class,
        ],
        'pipelines' => [
            EnsureMoonShineAdminLogin::class,
        ],
    ],

    // Authentication and profile
    'user_fields' => [
        'username' => 'email',
        'password' => 'password',
        'name' => 'name',
        'avatar' => false,
    ],

    // Layout, palette, pages, forms
    'layout' => App\MoonShine\Layouts\MoonShineLayout::class,
    'palette' => GreenPalette::class,

    'forms' => [
        'login' => LoginForm::class,
        'filters' => FiltersForm::class,
    ],

    'pages' => [
        'dashboard' => App\MoonShine\Pages\Dashboard::class,
        'profile' => ProfilePage::class,
        'login' => LoginPage::class,
        'error' => ErrorPage::class,
    ],

    // Localizations
    'locale' => 'ru',
    'locale_key' => ChangeLocale::KEY,
    'locales' => [
        'ru',
        'en',
    ],
];
