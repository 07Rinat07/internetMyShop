<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('app.supported_locales', [config('app.locale')]);
        $locale = (string) $request->session()->get('locale', config('app.locale'));

        if (! in_array($locale, $supported, true)) {
            $locale = (string) config('app.locale', 'ru');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
