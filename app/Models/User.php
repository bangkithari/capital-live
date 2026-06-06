<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasHashid;

    public const ACTIVE = true;
    public const INACTIVE = false;

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'department_id',
        'role_id',
        'password_hash',
        'full_name',
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'password_expiry_date',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password_expiry_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->full_name,
            'email' => $this->email,
            'role' => $this->role,
            'department' => $this->department?->code,
        ];
    }

    public function getNameAttribute(): ?string
    {
        return $this->full_name;
    }

    public function getIdAttribute(): ?string
    {
        return $this->user_id;
    }

    public function setNameAttribute(?string $value): void
    {
        $this->attributes['full_name'] = $value;
    }

    public function getPasswordAttribute(): ?string
    {
        return $this->password_hash;
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password_hash'] = $value;
    }

    public function getRoleAttribute(): string
    {
        return $this->roleModel?->name ?? (string) config('cpital.default_role_name');
    }

    public function setRoleAttribute(string|int|null $value): void
    {
        $this->attributes['role_id'] = $this->roleIdFromValue($value);
    }

    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    private function roleIdFromValue(string|int|null $value): int
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        $roleName = filled($value) ? (string) $value : (string) config('cpital.default_role_name');

        $defaultRoleName = (string) config('cpital.default_role_name');

        return Role::where('name', $roleName)->value('id')
            ?? Role::where('name', $defaultRoleName)->value('id')
            ?? Role::create(['name' => $defaultRoleName])->id;
    }

    public static function generateUserId(): string
    {
        $length = max(1, (int) config('cpital.generated_user_id_length'));
        $max = (10 ** $length) - 1;

        do {
            $userId = str_pad((string) random_int(1, $max), $length, '0', STR_PAD_LEFT);
        } while (static::whereKey($userId)->exists());

        return $userId;
    }

    public function isAdmin(): bool
    {
        return $this->role === config('cpital.admin_role_name');
    }

    /**
     * Get the user's initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', (string) $this->full_name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    /**
     * Get role badge color
     */
    public function getRoleBadgeAttribute(): array
    {
        return config('cpital.role_badges.' . $this->role)
            ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => ucfirst($this->role)];
    }
}
