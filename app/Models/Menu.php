<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

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
                ->with(['activeChildren' => fn ($query) => $query->where('is_active', self::ACTIVE)->orderBy('sort_order')])
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
