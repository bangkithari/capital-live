<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\RoleDepartmentMenu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Admin bypass — sees everything
        if ($user->isAdmin()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();
        $menuId = $this->resolveMenuId($routeName, $request->path());

        // No menu found → allow (route not tied to any menu)
        if ($menuId === null) {
            return $next($request);
        }

        // Public menu (menu_type is null) → visible to all
        $menuType = $this->getMenuType($menuId);
        if (blank($menuType)) {
            return $next($request);
        }

        // Check access via cache
        $allowed = $this->getAllowedMenuIds($user->role_id, $user->department_id);
        if (in_array($menuId, $allowed)) {
            return $next($request);
        }

        abort(403);
    }

    /**
     * Resolve route name → menu ID (cached 24h, invalidates on menu update)
     */
    private function resolveMenuId(?string $routeName, string $path): ?int
    {
        $routeMap = Cache::remember('menu_route_map', now()->addHours(24), function () {
            return Menu::where('is_active', true)
                ->whereNotNull('route_name')
                ->pluck('id', 'route_name')
                ->toArray();
        });

        if ($routeName && isset($routeMap[$routeName])) {
            return $routeMap[$routeName];
        }

        $urlMap = Cache::remember('menu_url_map', now()->addHours(24), function () {
            return Menu::where('is_active', true)
                ->whereNotNull('url')
                ->pluck('id', 'url')
                ->toArray();
        });

        return $urlMap['/' . $path] ?? null;
    }

    /**
     * Get menu_type for a menu ID (cached 24h)
     */
    private function getMenuType(int $menuId): ?string
    {
        $types = Cache::remember('menu_types', now()->addHours(24), function () {
            return Menu::pluck('menu_type', 'id')->toArray();
        });

        return $types[$menuId] ?? null;
    }

    /**
     * Get allowed menu IDs for role+department (cached 30min)
     */
    private function getAllowedMenuIds(int $roleId, int $deptId): array
    {
        return Cache::remember(
            "allowed_menus:{$roleId}:{$deptId}",
            now()->addMinutes(30),
            function () use ($roleId, $deptId) {
                return RoleDepartmentMenu::where('role_id', $roleId)
                    ->where('department_id', $deptId)
                    ->where('is_access', true)
                    ->pluck('menu_id')
                    ->toArray();
            }
        );
    }
}
