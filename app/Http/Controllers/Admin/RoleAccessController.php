<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleDepartmentMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleAccessController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('level_role')->orderBy('name')->get();
        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        // Preload role_department_menu for display
        $roleAccessMap = RoleDepartmentMenu::where('is_access', true)
            ->get()
            ->groupBy('menu_id')
            ->map(fn ($entries) => $entries->pluck('role_id')->unique()->values());

        return view('admin.role-access.index', compact('roles', 'menus', 'roleAccessMap'));
    }

    public function update(Request $request)
    {
        $roleNames = Role::pluck('name')->all();
        $roleMap = Role::pluck('id', 'name'); // name => id
        $departmentIds = Department::pluck('id')->toArray();

        $validated = $request->validate([
            'access' => ['array'],
            'access.*' => ['array'],
            'access.*.*' => [Rule::in($roleNames)],
            'public' => ['array'],
            'public.*' => ['integer', 'exists:menus,id'],
        ]);

        $access = $validated['access'] ?? [];
        $publicMenuIds = collect($validated['public'] ?? [])->map(fn ($id) => (int) $id);

        DB::transaction(function () use ($access, $publicMenuIds, $roleNames, $roleMap, $departmentIds) {
            Menu::query()->each(function (Menu $menu) use ($access, $publicMenuIds, $roleNames, $roleMap, $departmentIds) {
                // Public menu: visible to all, no role_department_menu entries needed
                if ($publicMenuIds->contains($menu->id)) {
                    $menu->update(['menu_type' => null]);
                    // Clear role_department_menu for this menu
                    RoleDepartmentMenu::where('menu_id', $menu->id)->delete();
                    return;
                }

                // Get selected roles for this menu
                $selectedRoleNames = collect($access[$menu->id] ?? [])
                    ->filter(fn ($role) => in_array($role, $roleNames, true))
                    ->unique()
                    ->values();

                // Update menu_type for display
                $menu->update([
                    'menu_type' => $selectedRoleNames->isEmpty() ? null : $selectedRoleNames->implode(','),
                ]);

                // Sync role_department_menu table
                // First, delete existing entries for this menu
                RoleDepartmentMenu::where('menu_id', $menu->id)->delete();

                // If no roles selected, menu is restricted to nobody (except admin bypass)
                if ($selectedRoleNames->isEmpty()) {
                    return;
                }

                // Create entries for each selected role × each department
                $insertData = [];
                foreach ($selectedRoleNames as $roleName) {
                    $roleId = $roleMap[$roleName] ?? null;
                    if (!$roleId) continue;

                    foreach ($departmentIds as $deptId) {
                        $insertData[] = [
                            'role_id' => $roleId,
                            'department_id' => $deptId,
                            'menu_id' => $menu->id,
                            'is_access' => true,
                        ];
                    }
                }

                if (!empty($insertData)) {
                    RoleDepartmentMenu::insert($insertData);
                }
            });
        });

        // Clear access cache so middleware picks up changes
        Cache::forget('menu_route_map');
        Cache::forget('menu_url_map');
        Cache::forget('menu_types');

        return redirect()->route('admin.role-access.index')
            ->with('success', 'Role access updated successfully.');
    }
}
