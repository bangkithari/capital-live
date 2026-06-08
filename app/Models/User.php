<?php

namespace App\Models;

use App\Models\Department;
use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $user_id
 * @property int $department_id
 * @property int $role_id
 * @property string $password_hash
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $remember_token
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $password_expiry_date
 * @property-read Department|null $department
 * @property-read string $hashid
 * @property-read string|null $id
 * @property-read string $initials
 * @property string|null $name
 * @property string|null $password
 * @property string $role
 * @property-read array $role_badge
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $roleModel
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserId($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasHashid;

    public const ACTIVE = true;
    public const INACTIVE = false;

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if (empty($user->department_id)) {
                $user->department_id = Department::firstOrCreate(
                    ['code' => config('cpital.default_department_code')],
                    ['name' => config('cpital.default_department_name')]
                )->id;
            }
        });
    }

    protected $fillable = [
        'user_id',
        'password_hash',
        'full_name',
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'department_id',
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
        return $this->normalizeBcryptHash($this->password_hash);
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
        return $this->normalizeBcryptHash($this->password_hash);
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password_hash'] = $value;
    }

    private function normalizeBcryptHash(?string $value): string
    {
        $hash = trim((string) $value);

        if (preg_match('/^\$2a\$(\d{2}\$[\.\/A-Za-z0-9]{53})$/', $hash, $matches) === 1) {
            return '$2y$' . $matches[1];
        }

        return $hash;
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
