<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();

        $parents = Menu::whereNull('parent_id')->orderBy('name')->get();

        // Prepare flat menu data with hashid for JS
        $menuData = $menus->flatMap(fn ($m) => collect([$m])->merge($m->children))->map(fn ($m) => [
            'id' => $m->id,
            'hashid' => $m->hashid,
            'name' => $m->name,
            'code' => $m->code,
            'url' => $m->url,
            'controller' => $m->controller,
            'action' => $m->action,
            'param' => $m->param,
            'icon' => $m->icon,
            'sort_order' => $m->sort_order,
            'parent_id' => $m->parent_id,
            'menu_type' => $m->menu_type,
            'stored_procedure' => $m->stored_procedure,
            'params_json' => $m->params_json,
            'is_active' => $m->is_active,
        ])->values();

        return view('admin.menus.index', compact('menus', 'parents', 'menuData'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:menus,code'],
            'url' => 'nullable|string|max:255',
            'controller' => 'nullable|string|max:50',
            'action' => 'nullable|string|max:50',
            'param' => 'nullable|integer',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'nullable|integer|min:0',
            'menu_type' => 'nullable|string|max:255',
            'stored_procedure' => 'nullable|string|max:200',
            'params_json' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['route_name'] = $this->resolveRouteName($validated['code']);

        if (filled($validated['route_name']) && Route::has($validated['route_name'])) {
            $validated['url'] = route($validated['route_name'], [], false);
        }

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('name')
            ->get();

        return view('admin.menus.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('menus', 'code')->ignore($menu->id)],
            'url' => 'nullable|string|max:255',
            'controller' => 'nullable|string|max:50',
            'action' => 'nullable|string|max:50',
            'param' => 'nullable|integer',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'nullable|integer|min:0',
            'menu_type' => 'nullable|string|max:255',
            'stored_procedure' => 'nullable|string|max:200',
            'params_json' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['route_name'] = $this->resolveRouteName($validated['code']);

        if (filled($validated['route_name']) && Route::has($validated['route_name'])) {
            $validated['url'] = route($validated['route_name'], [], false);
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        // Delete children first
        Menu::where('parent_id', $menu->id)->delete();
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Toggle active status via AJAX
     */
    public function toggle(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $menu->is_active,
        ]);
    }

    /**
     * Reorder menus via AJAX drag & drop
     */
    public function reorder(Request $request)
    {
        $items = $request->input('items', []);

        foreach ($items as $item) {
            Menu::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    private function resolveRouteName(string $code): ?string
    {
        return match (strtolower($code)) {
            'dashboard' => Route::has('dashboard') ? 'dashboard' : null,
            'user_mgmt' => Route::has('admin.users.index') ? 'admin.users.index' : null,
            'role_access' => Route::has('admin.role-access.index') ? 'admin.role-access.index' : null,
            default => null,
        };
    }
}
