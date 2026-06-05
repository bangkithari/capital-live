<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->unique()->numerify('######'),
            'department_id' => Department::firstOrCreate(
                ['code' => config('cpital.default_department_code')],
                ['name' => config('cpital.default_department_name')]
            )->id,
            'role_id' => Role::firstOrCreate(['name' => config('cpital.default_role_name')])->id,
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password_hash' => static::$password ??= Hash::make('password'),
            'is_active' => User::ACTIVE,
            'created_at' => now(),
            'updated_at' => now(),
            'password_expiry_date' => now()->addYears(3),
        ];
    }

    public function unverified(): static
    {
        return $this;
    }
}
