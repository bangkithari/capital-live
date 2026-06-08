<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $code
 * @property string|null $url
 * @property string|null $controller
 * @property string|null $action
 * @property string|null $route_name
 * @property int|null $param
 * @property string|null $icon
 * @property int|null $sort_order
 * @property bool|null $is_active
 * @property string|null $menu_type
 * @property string|null $stored_procedure
 * @property string|null $params_json
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menu> $activeChildren
 * @property-read int|null $active_children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menu> $children
 * @property-read int|null $children_count
 * @property-read array $allowed_roles
 * @property-read string $hashid
 * @property int|null $order
 * @property string|null $permission
 * @property-read string|null $resolved_url
 * @property string|null $slug
 * @property-read Menu|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoleDepartmentMenu> $roleAccesses
 * @property-read int|null $role_accesses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereMenuType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereParam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereParamsJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereStoredProcedure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereUrl($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use HasFactory, HasHashid;

    public const ACTIVE = true;
    public const INACTIVE = false;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'url',
        'controller',
        'action',
        'param',
        'icon',
        'parent_id',
        'sort_order',
        'order',
        'is_active',
        'menu_type',
        'permission',
        'route_name',
        'stored_procedure',
        'params_json',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    public function activeChildren()
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('is_active', self::ACTIVE)->orderBy('sort_order');
    }

    public function roleAccesses()
    {
        return $this->hasMany(RoleDepartmentMenu::class, 'menu_id');
    }

    public function getSlugAttribute(): ?string
    {
        return $this->code;
    }

    public function getOrderAttribute(): ?int
    {
        return $this->sort_order;
    }

    public function getPermissionAttribute(): ?string
    {
        return $this->menu_type;
    }

    public function getRouteNameAttribute(): ?string
    {
        return $this->attributes['route_name'] ?? null;
    }

    public function setSlugAttribute(?string $value): void
    {
        $this->attributes['code'] = $value;
    }

    public function setOrderAttribute(?int $value): void
    {
        $this->attributes['sort_order'] = $value;
    }

    public function setPermissionAttribute(?string $value): void
    {
        $this->attributes['menu_type'] = $value;
    }

    public function setRouteNameAttribute(?string $value): void
    {
        $this->attributes['route_name'] = $value;
    }

    public function getResolvedUrlAttribute(): ?string
    {
        if (filled($this->route_name) && Route::has($this->route_name)) {
            return route($this->route_name, [], false);
        }

        return $this->url;
    }

    public function getAllowedRolesAttribute(): array
    {
        if (blank($this->menu_type)) {
            return [];
        }

        return collect(explode(',', $this->menu_type))
            ->map(fn (string $role) => trim($role))
            ->filter()
            ->values()
            ->all();
    }

    public function isVisibleToRole($user = null): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $user = $this->resolveUserContext($user);

        if (! $user instanceof User) {
            return false;
        }

        // Admin sees everything
        if ($user->isAdmin()) {
            return true;
        }

        // Public menu (menu_type is null) → visible to all
        if (blank($this->menu_type)) {
            return true;
        }

        // Check role_department_menu table for role+department access
        if ($this->hasDirectAccessFor($user)) {
            return true;
        }

        // Check if any child is visible (parent visible if child is)
        return $this->activeChildren()
            ->get()
            ->contains(fn (Menu $child) => $child->isVisibleToRole($user));
    }

    /**
     * Get all top-level menus with their active children
     */
    public static function getMenuTree($user = null)
    {
        $user = static::resolveUserContext($user ?? auth()->user());

        if (! $user instanceof User) {
            return collect();
        }

        if ($user->isAdmin()) {
            return static::whereNull('parent_id')
                ->where('is_active', self::ACTIVE)
                ->with(['activeChildren' => fn ($query) => $query->where('is_active', self::ACTIVE)])
                ->orderBy('sort_order')
                ->get()
                ->map(function (Menu $menu) {
                    $menu->setRelation(
                        'activeChildren',
                        $menu->activeChildren->values()
                    );

                    return $menu;
                })
                ->values();
        }

        return static::whereNull('parent_id')
            ->where('is_active', self::ACTIVE)
            ->orderBy('sort_order')
            ->get()
            ->filter(function (Menu $menu) use ($user) {
                return $menu->isVisibleToRole($user);
            })
            ->map(function (Menu $menu) use ($user) {
                $menu->setRelation(
                    'activeChildren',
                    $menu->activeChildren
                        ->filter(fn (Menu $child) => $child->isVisibleToRole($user))
                        ->values()
                );

                return $menu;
            })
            ->values();
    }

    private static function resolveUserContext($user = null): ?User
    {
        if ($user instanceof User) {
            return $user;
        }

        return auth()->user();
    }

    private function hasDirectAccessFor(User $user): bool
    {
        return $this->roleAccesses()
            ->where('role_id', $user->role_id)
            ->where('department_id', $user->department_id)
            ->where('is_access', self::ACTIVE)
            ->exists();
    }
}
