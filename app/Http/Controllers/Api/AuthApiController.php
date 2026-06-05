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
 * Authenticate users with user_id and password and manage JWT access tokens.
 */
#[Group('Authentication')]
class AuthApiController extends Controller
{
    /**
     * Login
     *
     * Authenticate a user and return a JWT bearer token.
     *
     * @bodyParam user_id string required User login ID. Example: 000001
     * @bodyParam password string required User password. Example: password
     *
     * @throws ValidationException
     */
    #[Response(200, type: 'array{access_token: string, token_type: string, expires_in: int}')]
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'user_id' => $validated['user_id'],
            'password' => $validated['password'],
            'is_active' => User::ACTIVE,
        ];

        // Existing SQL Server data uses bcrypt hashes in password_hash.
        // Laravel remains compatible through User::getAuthPassword().
        // Future Argon2id upgrade path: rehash after successful login when
        // Hash::needsRehash($user->password_hash) is true and the hash driver
        // has been changed to argon2id in config/hashing.php.
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
