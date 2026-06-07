<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasDepartment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use HasDepartment;

    public function index()
    {
        $users = User::with('roleModel', 'department')->orderBy('full_name')
            ->paginate(config('cpital.per_page', 15));

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('level_role')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'role'          => ['required', Rule::exists('roles', 'name')],
            'department_id' => ['required', Rule::exists('departments', 'id')],
            'is_active'     => ['nullable', 'boolean'],
        ]);

        User::create([
            'user_id'       => User::generateUserId(),
            'department_id' => $validated['department_id'],
            'full_name'     => $validated['name'],
            'email'         => $validated['email'],
            'password_hash' => bcrypt($validated['password']),
            'role'          => $validated['role'],
            'is_active'     => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('level_role')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->getKey(), 'user_id')],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'          => ['required', Rule::exists('roles', 'name')],
            'department_id' => ['required', Rule::exists('departments', 'id')],
            'is_active'     => ['nullable', 'boolean'],
        ]);

        $data = [
            'full_name'     => $validated['name'],
            'email'         => $validated['email'],
            'role'          => $validated['role'],
            'department_id' => $validated['department_id'],
            'is_active'     => $request->boolean('is_active'),
        ];

        if (filled($validated['password'] ?? null)) {
            $data['password_hash'] = bcrypt($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show the v2 (AJAX) create user form.
     */
    public function createV2()
    {
        $roles = Role::orderBy('level_role')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.users.create-v2', compact('roles', 'departments'));
    }

    /**
     * Store a new user via AJAX (JSON response).
     */
    public function storeV2(Request $request)
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
            'user'    => [
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
