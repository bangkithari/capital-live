<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'user_id' => User::generateUserId(),
            'department_id' => $this->defaultDepartmentId(),
            'role_id' => $this->defaultRoleId(),
            'full_name' => $request->name,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'is_active' => User::ACTIVE,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function defaultDepartmentId(): int
    {
        return Department::firstOrCreate(
            ['code' => config('cpital.default_department_code')],
            ['name' => config('cpital.default_department_name')]
        )->id;
    }

    private function defaultRoleId(): int
    {
        return Role::firstOrCreate(['name' => config('cpital.default_role_name')])->id;
    }
}
