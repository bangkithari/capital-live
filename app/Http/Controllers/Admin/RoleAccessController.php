<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
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

        return view('admin.role-access.index', compact('roles', 'menus'));
    }

    public function update(Request $request)
    {
        $roleNames = Role::pluck('name')->all();

        $validated = $request->validate([
            'access' => ['array'],
            'access.*' => ['array'],
            'access.*.*' => [Rule::in($roleNames)],
            'public' => ['array'],
            'public.*' => ['integer', 'exists:menus,id'],
        ]);

        $access = $validated['access'] ?? [];
        $publicMenuIds = collect($validated['public'] ?? [])->map(fn ($id) => (int) $id);

        Menu::query()->each(function (Menu $menu) use ($access, $publicMenuIds) {
            if ($publicMenuIds->contains($menu->id)) {
                $menu->update(['menu_type' => null]);

                return;
            }

            $roles = collect($access[$menu->id] ?? [])
                ->filter(fn ($role) => in_array($role, $roleNames, true))
                ->unique()
                ->values();

            $menu->update([
                'menu_type' => $roles->isEmpty() ? null : $roles->implode(','),
            ]);
        });

        return redirect()->route('admin.role-access.index')
            ->with('success', 'Role access updated successfully.');
    }
}
