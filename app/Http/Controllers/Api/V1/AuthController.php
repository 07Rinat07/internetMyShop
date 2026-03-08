<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\AuthUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private const TOKEN_ABILITIES = [
        'auth:self',
        'profile:read',
        'profile:write',
        'orders:read',
    ];

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return $this->tokenResponse($user, $request->input('device_name', 'nuxt-client'), 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->tokenResponse($user, $request->input('device_name', 'nuxt-client'));
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => (new AuthUserResource($request->user()))->resolve(),
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([], 204);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([], 204);
    }

    private function tokenResponse(User $user, string $deviceName, int $status = 200)
    {
        $expiration = (int) config('sanctum.expiration');
        $expiresAt = $expiration > 0 ? now()->addMinutes($expiration) : null;
        $token = $user->createToken($deviceName, self::TOKEN_ABILITIES, $expiresAt)->plainTextToken;

        return response()->json([
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $token,
                'user' => (new AuthUserResource($user))->resolve(),
            ],
        ], $status);
    }
}
