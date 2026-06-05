@props(['menus'])

@php
    $menus = $menus ?? \App\Models\Menu::getMenuTree();
@endphp

@foreach ($menus as $menu)
    @php
        $menuUrl = $menu->resolved_url ?? $menu->url;
        $menuIsActive = filled($menu->route_name)
            ? request()->routeIs($menu->route_name)
            : filled($menuUrl) && request()->is(ltrim($menuUrl, '/') . '*');
    @endphp

    @if ($menu->activeChildren->count() > 0)
        <div x-data="{ open: false }" class="mb-0.5">
            <button
                @click="open = !open"
                class="flex items-center w-full px-3 py-2.5 text-sm rounded-xl hover:bg-slate-700/50 transition-all duration-200 text-slate-300 hover:text-white"
            >
                <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                    <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-[18px] h-[18px]"></i>
                </span>
                <span class="ml-3 flex-1 text-left font-medium">{{ $menu->name }}</span>
                <svg
                    class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-collapse class="ml-5 mt-1 space-y-0.5 border-l border-slate-700/50 pl-3">
                @foreach ($menu->activeChildren as $child)
                    @php
                        $childUrl = $child->resolved_url ?? $child->url;
                        $childIsActive = filled($child->route_name)
                            ? request()->routeIs($child->route_name)
                            : filled($childUrl) && request()->is(ltrim($childUrl, '/') . '*');
                    @endphp

                    @if (filled($childUrl))
                        <a
                            href="{{ $childUrl }}"
                            class="flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200 {{ $childIsActive ? 'sidebar-active-item text-blue-400 font-medium' : 'text-slate-400 hover:text-white hover:bg-slate-700/30' }}"
                        >
                            <span class="mr-2.5 flex-shrink-0">
                                <i data-lucide="{{ $child->icon ?? 'circle' }}" class="w-4 h-4"></i>
                            </span>
                            {{ $child->name }}
                        </a>
                    @else
                        <span class="flex items-center px-3 py-2 text-sm rounded-lg text-slate-500">
                            <span class="mr-2.5 flex-shrink-0">
                                <i data-lucide="{{ $child->icon ?? 'circle' }}" class="w-4 h-4"></i>
                            </span>
                            {{ $child->name }}
                        </span>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        @if (filled($menuUrl))
            <a
                href="{{ $menuUrl }}"
                class="flex items-center px-3 py-2.5 mb-0.5 text-sm rounded-xl transition-all duration-200 {{ $menuIsActive ? 'sidebar-active-item text-blue-400 font-medium bg-slate-700/30' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}"
            >
                <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                    <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-[18px] h-[18px]"></i>
                </span>
                <span class="ml-3 font-medium">{{ $menu->name }}</span>
            </a>
        @else
            <span class="flex items-center px-3 py-2.5 mb-0.5 text-sm rounded-xl text-slate-500">
                <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                    <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-[18px] h-[18px]"></i>
                </span>
                <span class="ml-3 font-medium">{{ $menu->name }}</span>
            </span>
        @endif
    @endif
@endforeach
