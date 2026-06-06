<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWTGuard;

/**
 * API Authentication Controller
 *
 * Authenticate users with user_id OR email and password to receive a JWT bearer token.
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

        // Resolve user_id from email if needed
        $userId = $validated['user_id'] ?? null;

        if (!$userId && !empty($validated['email'])) {
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['No account found with this email address.'],
                ]);
            }
            $userId = $user->user_id;
        }

        $credentials = [
            'user_id' => $userId,
            'password' => $validated['password'],
            'is_active' => User::ACTIVE,
        ];

        $token = $this->apiGuard()->attempt($credentials);

        if (! is_string($token)) {
            throw ValidationException::withMessages([
                'user_id' => ['The provided credentials are incorrect or the account is inactive.'],
            ]);
        }

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
