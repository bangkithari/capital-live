<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasDepartment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    use HasDepartment;

    /**
     * Create a new user.
     *
     * Requires authentication. Only admins can create users.
     *
     * @bodyParam name string required Full name. Example: John Doe
     * @bodyParam email string required Must be unique. Example: john@example.com
     * @bodyParam password string required Minimum 8 characters. Example: secret123
     * @bodyParam password_confirmation string required Must match password. Example: secret123
     * @bodyParam role string required Role name. Example: officer
     * @bodyParam department_id int required Department ID. Example: 1
     * @bodyParam is_active boolean Whether the user is active. Example: true
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'role'          => ['required', Rule::exists('roles', 'name')],
            'department_id' => ['required', Rule::exists('departments', 'id')],
            'is_active'     => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'user_id'       => User::generateUserId(),
            'department_id' => $validated['department_id'],
            'full_name'     => $validated['name'],
            'email'         => $validated['email'],
            'password_hash' => bcrypt($validated['password']),
            'role'          => $validated['role'],
            'is_active'     => $request->boolean('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => "User \"{$user->full_name}\" created successfully.",
            'data'    => [
                'user_id'   => $user->user_id,
                'name'      => $user->full_name,
                'email'     => $user->email,
                'role'      => $user->role,
                'department' => $user->department?->name,
                'is_active' => (bool) $user->is_active,
            ],
        ], 201);
    }
}
