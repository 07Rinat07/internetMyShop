<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class Administrator
{
    public function handle($request, Closure $next, $guard = null)
    {
        Gate::authorize('access-admin');

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
}
