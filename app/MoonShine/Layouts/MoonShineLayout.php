<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Brand\BrandResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\Page\PageResource;
use App\MoonShine\Resources\Product\ProductResource;
use App\MoonShine\Resources\SiteContent\SiteContentResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\AssetManager\InlineCss;
use MoonShine\ColorManager\ColorManager;
use MoonShine\ColorManager\Palettes\GreenPalette;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\FlexibleRender;
use MoonShine\UI\Components\Layout\Div;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = GreenPalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
            InlineCss::make(<<<'CSS'
                :root:not(.dark) {
                    --ims-admin-body-bg:
                        radial-gradient(circle at top right, rgba(184, 139, 76, 0.18), transparent 26%),
                        radial-gradient(circle at bottom left, rgba(102, 130, 91, 0.14), transparent 24%),
                        linear-gradient(180deg, #efe7da 0%, #e1d6c4 100%);
                    --ims-admin-menu-bg:
                        linear-gradient(180deg, rgba(248, 243, 235, 0.98) 0%, rgba(240, 231, 219, 0.98) 100%),
                        repeating-linear-gradient(135deg, rgba(73, 68, 55, 0.03) 0 1px, transparent 1px 18px);
                    --ims-admin-main-bg:
                        radial-gradient(circle at top right, rgba(184, 139, 76, 0.12), transparent 24%),
                        linear-gradient(180deg, rgba(244, 239, 231, 0.95), rgba(235, 227, 214, 0.98));
                    --ims-admin-box-bg:
                        linear-gradient(180deg, rgba(255, 252, 246, 0.98) 0%, rgba(246, 240, 232, 0.98) 100%);
                    --ims-admin-border: rgba(121, 94, 58, 0.14);
                    --ims-admin-title-color: #1f2520;
                    --ims-admin-link: rgba(42, 49, 44, 0.82);
                    --ims-admin-link-active: #111714;
                    --ims-admin-link-active-bg: linear-gradient(135deg, rgba(184, 139, 76, 0.18), rgba(101, 126, 86, 0.16));
                    --ims-admin-hero-text: rgba(41, 48, 43, 0.76);
                    --ims-admin-note: rgba(54, 61, 56, 0.72);
                    --ims-admin-stat-label: rgba(160, 113, 48, 0.92);
                    --ims-admin-stat-value: #162018;
                    --ms-cm-body: oklch(95% 0.015 92);
                    --ms-cm-primary: oklch(64% 0.11 72);
                    --ms-cm-primary-text: oklch(98% 0.01 92);
                    --ms-cm-secondary: oklch(87% 0.035 145);
                    --ms-cm-secondary-text: oklch(22% 0.02 145);
                    --ms-cm-base-text: oklch(22% 0.02 145);
                    --ms-cm-base-stroke: oklch(58% 0.05 72 / 18%);
                    --ms-cm-base-default: oklch(97% 0.01 92);
                    --ms-cm-base-50: oklch(96% 0.012 92);
                    --ms-cm-base-100: oklch(93% 0.02 92);
                    --ms-cm-base-200: oklch(89% 0.025 92);
                    --ms-cm-base-300: oklch(84% 0.03 92);
                    --ms-cm-base-400: oklch(76% 0.04 92);
                    --ms-cm-base-500: oklch(67% 0.05 92);
                    --ms-cm-base-600: oklch(57% 0.05 92);
                    --ms-cm-base-700: oklch(47% 0.05 92);
                    --ms-cm-base-800: oklch(34% 0.04 92);
                    --ms-cm-base-900: oklch(24% 0.03 92);
                    --ms-layout-body-bg-color: oklch(92% 0.02 92);
                    --ms-layout-page-bg-color: oklch(95% 0.015 92);
                    --ms-box-bg-color: oklch(98% 0.01 92);
                    --ms-card-bg-color: oklch(98% 0.01 92);
                    --ms-form-default-bg-color: oklch(98% 0.01 92);
                    --ms-form-default-color: oklch(22% 0.02 145);
                    --ms-form-focus-border-color: oklch(64% 0.11 72);
                    --ms-form-focus-ring-color: oklch(64% 0.11 72 / 16%);
                    --ms-btn-bg-color: oklch(64% 0.11 72);
                    --ms-btn-color: oklch(98% 0.01 92);
                    --ms-btn-hover-bg-color: oklch(69% 0.11 74);
                    --ms-btn-hover-color: oklch(98% 0.01 92);
                    --ms-menu-item-active-bg-color: oklch(92% 0.03 92);
                    --ms-menu-item-active-color: oklch(19% 0.02 145);
                    --ms-menu-item-hover-bg-color: oklch(95% 0.02 92);
                    --ms-dropdown-bg-color: oklch(98% 0.01 92);
                    --ms-dropdown-color: oklch(22% 0.02 145);
                    --ms-alert-bg-color: oklch(95% 0.03 145);
                    --ms-alert-color: oklch(26% 0.02 145);
                    --ms-table-bg-color: oklch(98% 0.01 92);
                    --ms-table-thead-bg-color: oklch(94% 0.02 92);
                }

                :root.dark {
                    --ims-admin-body-bg:
                        radial-gradient(circle at top right, rgba(179, 132, 61, 0.12), transparent 28%),
                        radial-gradient(circle at bottom left, rgba(64, 92, 67, 0.16), transparent 26%),
                        linear-gradient(180deg, #162018 0%, #121915 100%);
                    --ims-admin-menu-bg:
                        linear-gradient(180deg, rgba(24, 34, 27, 0.98) 0%, rgba(17, 24, 20, 0.98) 100%),
                        repeating-linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0 1px, transparent 1px 18px);
                    --ims-admin-main-bg:
                        radial-gradient(circle at top right, rgba(185, 134, 64, 0.08), transparent 22%),
                        linear-gradient(180deg, rgba(24, 32, 25, 0.94), rgba(18, 25, 21, 0.98));
                    --ims-admin-box-bg:
                        linear-gradient(180deg, rgba(34, 44, 37, 0.96) 0%, rgba(26, 34, 29, 0.96) 100%);
                    --ims-admin-border: rgba(196, 161, 104, 0.12);
                    --ims-admin-title-color: #f2eadf;
                    --ims-admin-link: rgba(241, 233, 221, 0.78);
                    --ims-admin-link-active: #fff8ed;
                    --ims-admin-link-active-bg: linear-gradient(135deg, rgba(174, 130, 65, 0.2), rgba(58, 88, 62, 0.26));
                    --ims-admin-hero-text: rgba(241, 233, 221, 0.76);
                    --ims-admin-note: rgba(241, 233, 221, 0.68);
                    --ims-admin-stat-label: rgba(211, 178, 119, 0.86);
                    --ims-admin-stat-value: #fff8ed;
                    --ms-cm-body: oklch(22% 0.02 145);
                    --ms-cm-primary: oklch(66% 0.12 72);
                    --ms-cm-primary-text: oklch(17% 0.02 145);
                    --ms-cm-secondary: oklch(34% 0.03 145);
                    --ms-cm-secondary-text: oklch(92% 0.02 92);
                    --ms-cm-base-text: oklch(93% 0.02 92);
                    --ms-cm-base-stroke: oklch(58% 0.06 72 / 22%);
                    --ms-cm-base-default: oklch(24% 0.02 145);
                    --ms-cm-base-50: oklch(26% 0.02 145);
                    --ms-cm-base-100: oklch(30% 0.025 145);
                    --ms-cm-base-200: oklch(34% 0.028 145);
                    --ms-cm-base-300: oklch(39% 0.03 145);
                    --ms-cm-base-400: oklch(45% 0.04 145);
                    --ms-cm-base-500: oklch(54% 0.05 145);
                    --ms-cm-base-600: oklch(63% 0.06 145);
                    --ms-cm-base-700: oklch(73% 0.08 72);
                    --ms-cm-base-800: oklch(83% 0.06 78);
                    --ms-cm-base-900: oklch(90% 0.03 92);
                    --ms-layout-body-bg-color: oklch(18% 0.016 145);
                    --ms-layout-page-bg-color: oklch(22% 0.02 145);
                    --ms-box-bg-color: oklch(24% 0.02 145);
                    --ms-card-bg-color: oklch(25% 0.02 145);
                    --ms-form-default-bg-color: oklch(22% 0.018 145);
                    --ms-form-default-color: oklch(93% 0.02 92);
                    --ms-form-focus-border-color: oklch(66% 0.12 72);
                    --ms-form-focus-ring-color: oklch(66% 0.12 72 / 24%);
                    --ms-btn-bg-color: oklch(66% 0.12 72);
                    --ms-btn-color: oklch(18% 0.016 145);
                    --ms-btn-hover-bg-color: oklch(73% 0.1 74);
                    --ms-btn-hover-color: oklch(18% 0.016 145);
                    --ms-menu-item-active-bg-color: oklch(31% 0.035 145);
                    --ms-menu-item-active-color: oklch(95% 0.02 92);
                    --ms-menu-item-hover-bg-color: oklch(28% 0.028 145);
                    --ms-dropdown-bg-color: oklch(24% 0.02 145);
                    --ms-dropdown-color: oklch(93% 0.02 92);
                    --ms-alert-bg-color: oklch(28% 0.04 145);
                    --ms-alert-color: oklch(92% 0.02 92);
                    --ms-table-bg-color: oklch(24% 0.02 145);
                    --ms-table-thead-bg-color: oklch(28% 0.03 145);
                }

                body {
                    background: var(--ims-admin-body-bg);
                }

                .layout-menu {
                    background: var(--ims-admin-menu-bg);
                    border-right: 1px solid var(--ims-admin-border);
                    box-shadow: 16px 0 40px rgba(0, 0, 0, 0.16);
                }

                .layout-main {
                    background: var(--ims-admin-main-bg);
                }

                .layout-page,
                .layout-content {
                    background: transparent;
                }

                .layout-content > h1,
                .heading .h2,
                .heading .h3,
                .breadcrumbs,
                .breadcrumbs a {
                    color: var(--ims-admin-title-color);
                }

                .box {
                    border: 1px solid var(--ims-admin-border);
                    border-radius: 24px;
                    background: var(--ims-admin-box-bg);
                    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.22);
                }

                .alert {
                    border-radius: 18px;
                    border: 1px solid var(--ims-admin-border);
                }

                .menu-header {
                    border-bottom: 1px solid var(--ims-admin-border);
                }

                .menu-link,
                .menu-button {
                    border-radius: 16px;
                    margin-bottom: 6px;
                    color: var(--ims-admin-link);
                }

                .menu-link:hover,
                .menu-button:hover,
                .menu-link.active,
                .menu-item.active > .menu-link,
                .menu-item.active > .menu-button {
                    background: var(--ims-admin-link-active-bg);
                    color: var(--ims-admin-link-active);
                }

                .menu-text {
                    white-space: normal;
                    line-height: 1.35;
                }

                .table {
                    border-radius: 22px;
                    overflow: hidden;
                }

                .ims-admin-shortcuts {
                    display: grid;
                    gap: .5rem;
                    width: 100%;
                    margin-top: .75rem;
                }

                .ims-admin-shortcuts .btn {
                    width: 100%;
                    justify-content: center;
                    border-radius: 999px;
                }

                .ims-admin-shortcuts form {
                    margin: 0;
                }

                .ims-dashboard-hero {
                    background:
                        radial-gradient(circle at top right, rgba(185, 134, 64, 0.18), transparent 30%),
                        var(--ims-admin-box-bg);
                }

                .ims-dashboard-hero__eyebrow {
                    display: inline-flex;
                    margin-bottom: .85rem;
                    padding: .45rem .7rem;
                    font-size: .75rem;
                    font-weight: 800;
                    letter-spacing: .14em;
                    text-transform: uppercase;
                    color: #d3b277;
                    background: rgba(185, 134, 64, 0.12);
                    border: 1px solid rgba(185, 134, 64, 0.18);
                    border-radius: 999px;
                }

                .ims-dashboard-hero__text {
                    max-width: 54rem;
                    margin: 0;
                    color: var(--ims-admin-hero-text);
                    line-height: 1.75;
                }

                .ims-dashboard-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: .75rem;
                    margin-top: 1.5rem;
                }

                .ims-dashboard-actions .btn {
                    min-width: 10rem;
                    border-radius: 999px;
                }

                .ims-stat-grid {
                    display: grid !important;
                    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                    gap: 1rem;
                    align-items: stretch;
                }

                .ims-stat-card {
                    min-height: 12rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    background: var(--ims-admin-box-bg);
                }

                .ims-stat-card__label {
                    display: block;
                    font-size: .76rem;
                    font-weight: 800;
                    letter-spacing: .14em;
                    text-transform: uppercase;
                    color: var(--ims-admin-stat-label);
                }

                .ims-stat-card__value {
                    display: block;
                    margin-top: 1rem;
                    font-size: clamp(2rem, 3vw, 2.75rem);
                    font-weight: 800;
                    line-height: 1;
                    color: var(--ims-admin-stat-value);
                }

                .ims-stat-card__note {
                    display: block;
                    margin-top: .9rem;
                    color: var(--ims-admin-note);
                    line-height: 1.55;
                }

                @media (max-width: 991.98px) {
                    .ims-dashboard-actions {
                        flex-direction: column;
                    }

                    .ims-dashboard-actions .btn {
                        width: 100%;
                    }
                }
            CSS),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuItem::make(CategoryResource::class, __('admin.menu.categories')),
            MenuItem::make(BrandResource::class, __('admin.menu.brands')),
            MenuItem::make(ProductResource::class, __('admin.menu.products')),
            MenuItem::make(OrderResource::class, __('admin.menu.orders')),
            MenuItem::make(UserResource::class, __('admin.menu.users')),
            MenuItem::make(SiteContentResource::class, __('admin.menu.site_content')),
            MenuItem::make(PageResource::class, __('admin.menu.pages')),
        ];
    }

    protected function sidebarTopSlot(): array
    {
        return [
            Div::make([
                ActionButton::make(__('site.navigation.back'), $this->previousAdminUrl())->secondary(),
                ActionButton::make(__('site.navigation.to_site'), route('index'))->info(),
                ...$this->localeButtons(),
                ActionButton::make(__('site.account.logout'), 'javascript:void(0);')
                    ->error()
                    ->customAttributes([
                        'onclick' => "document.getElementById('ims-admin-logout-form').submit(); return false;",
                    ]),
                FlexibleRender::make(
                    static fn (): string => sprintf(
                        '<form id="ims-admin-logout-form" action="%s" method="POST" style="display:none;">%s%s</form>',
                        route('moonshine.logout'),
                        csrf_field(),
                        method_field('DELETE'),
                    )
                ),
            ])->class('ims-admin-shortcuts'),
        ];
    }

    /**
     * @param  ColorManager  $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    private function previousAdminUrl(): string
    {
        $previous = url()->previous();
        $current = url()->current();

        if (! empty($previous) && $previous !== $current) {
            return $previous;
        }

        return route('moonshine.index');
    }

    private function localeButtons(): array
    {
        $currentLocale = app()->getLocale();

        return array_map(
            static function (string $locale) use ($currentLocale): ActionButton {
                $button = ActionButton::make(
                    strtoupper($locale),
                    route('locale.switch', ['locale' => $locale])
                );

                return $currentLocale === $locale
                    ? $button->primary()
                    : $button->secondary();
            },
            config('app.supported_locales', ['ru'])
        );
    }
}
