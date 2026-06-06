<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWTGuard;

/**
 * API Authentication Controller
 *
 * Authenticate users with user_id OR email and password to receive a JWT bearer token.
 * Rate limited to 5 attempts per minute per identifier+IP.
 */
#[Group('Authentication')]
class AuthApiController extends Controller
{
    /**
     * Login
     *
     * Authenticate a user and return a JWT bearer token.
     * Accepts either `user_id` (e.g., 000001) or `email` (e.g., admin@capital.com).
     *
     * @bodyParam user_id string User login ID. Example: 000001
     * @bodyParam email string User email address. Example: admin@capital.com
     * @bodyParam password string required User password. Example: admin
     *
     * @throws ValidationException
     */
    #[Response(200, type: 'array{access_token: string, token_type: string, expires_in: int}')]
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Must provide at least one identifier
        if (empty($validated['user_id']) && empty($validated['email'])) {
            throw ValidationException::withMessages([
                'user_id' => ['Please provide either user_id or email.'],
            ]);
        }

        $identifier = $validated['user_id'] ?? $validated['email'];

        // Rate limiting: 5 attempts per minute per identifier+IP
        $throttleKey = Str::transliterate(Str::lower($identifier) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'user_id' => [__('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds])],
            ]);
        }

        // Single query: find by email OR user_id (same as web LoginRequest)
        $user = User::query()
            ->where('email', $identifier)
            ->orWhere('user_id', $identifier)
            ->first();

        // Validate: user exists, active, password matches
        if (! $user || ! $user->is_active || ! Hash::check($validated['password'], $user->getAuthPassword())) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'user_id' => ['The provided credentials are incorrect or the account is inactive.'],
            ]);
        }

        // Success: clear rate limit + generate token
        RateLimiter::clear($throttleKey);

        $token = $this->apiGuard()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Current user
     *
     * Return the authenticated API user.
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'data' => Auth::guard('api')->user(),
        ]);
    }

    /**
     * Refresh token
     *
     * Invalidate the current JWT and return a new token.
     */
    #[Response(200, type: 'array{access_token: string, token_type: string, expires_in: int}')]
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken($this->apiGuard()->refresh());
    }

    /**
     * Logout
     *
     * Invalidate the current JWT token.
     */
    public function logout(): JsonResponse
    {
        $this->apiGuard()->logout();

        return response()->json([
            'message' => 'Successfully logged out.',
        ]);
    }

    private function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (int) config('jwt.ttl', 60) * 60,
        ]);
    }

    private function apiGuard(): JWTGuard
    {
        /** @var JWTGuard $guard */
        $guard = Auth::guard('api');

        return $guard;
    }
}
