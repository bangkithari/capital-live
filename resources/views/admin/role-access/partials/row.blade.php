@php
    $allowedRoles = $menu->allowed_roles;
    $isPublic = blank($menu->menu_type);
@endphp

<tr class="{{ $isChild ? 'bg-slate-50/50' : 'hover:bg-blue-50/30' }} transition-colors">
    <td class="px-5 py-3">
        <div class="flex items-center {{ $isChild ? 'pl-8' : '' }}">
            @if ($isChild)
                <span class="w-4 h-px bg-slate-300 mr-2"></span>
            @endif
            <div class="w-8 h-8 {{ $isChild ? 'bg-violet-50' : 'bg-slate-100' }} rounded-lg flex items-center justify-center mr-3">
                <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-4 h-4 {{ $isChild ? 'text-violet-400' : 'text-slate-500' }}"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-700">{{ $menu->name }}</p>
                <p class="text-xs text-slate-400 font-mono">{{ $menu->url ?? $menu->action ?? 'parent menu' }}</p>
            </div>
        </div>
    </td>
    <td class="px-5 py-3 text-center">
        <label class="inline-flex items-center justify-center">
            <input type="checkbox"
                   name="public[]"
                   value="{{ $menu->id }}"
                   @checked($isPublic)
                   class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 js-role-public"
                   data-menu-id="{{ $menu->id }}">
        </label>
    </td>
    @foreach ($roles as $role)
        <td class="px-5 py-3 text-center">
            <label class="inline-flex items-center justify-center">
                <input type="checkbox"
                       name="access[{{ $menu->id }}][]"
                       value="{{ $role->name }}"
                       @checked(in_array($role->name, $allowedRoles, true))
                       @disabled($isPublic)
                       class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 js-role-access"
                       data-menu-id="{{ $menu->id }}">
            </label>
        </td>
    @endforeach
</tr>
