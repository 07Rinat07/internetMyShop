<?php

namespace App\Providers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        AuthenticationException::redirectUsing(
            fn (Request $request): ?string => $this->authenticationRedirectPath($request)
        );
        AuthenticateSession::redirectUsing(
            fn (Request $request): ?string => $this->authenticationRedirectPath($request)
        );

        Blade::directive('icon', function ($expression) {
            $name = str_replace("'", '', $expression);

            return '<i class="fas fa-'.$name.'"></i>';
        });
        Blade::directive('price', function ($expression) {
            return "<?php echo number_format((float) ($expression), 0, '.', ' '); ?>";
        });
        Blade::if('admin', function () {
            return auth()->check() && Gate::allows('access-admin');
        });
    }

    private function authenticationRedirectPath(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $adminPrefix = trim((string) config('moonshine.prefix', 'admin'), '/');

        if ($request->routeIs('moonshine.*') || $request->is($adminPrefix, "{$adminPrefix}/*")) {
            return route('moonshine.login');
        }

        return route('user.login');
    }
}
