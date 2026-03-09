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

        $locale = (string) $request->header('X-Locale', '');

        if (! in_array($locale, $supported, true)) {
            $locale = (string) $request->cookie('locale', '');
        }

        if (! in_array($locale, $supported, true) && $request->hasSession()) {
            $locale = (string) $request->session()->get('locale', config('app.locale'));
        }

        if (! in_array($locale, $supported, true)) {
            $locale = (string) config('app.locale', 'ru');
        }

        if ($request->hasSession() && $request->session()->get('locale') !== $locale) {
            $request->session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
