<?php

declare(strict_types=1);

namespace App\MoonShine\Pipelines;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnsureMoonShineAdminLogin
{
    /**
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = User::query()
            ->where('email', (string) $request->input('username'))
            ->first();

        if (! $user instanceof User || ! $user->isAdmin()) {
            throw ValidationException::withMessages([
                'username' => __('moonshine::auth.failed'),
            ]);
        }

        return $next($request);
    }
}
