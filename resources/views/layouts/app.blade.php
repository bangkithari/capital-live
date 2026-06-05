<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CpitalLive') }} - @yield('title', 'Dashboard')</title>

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.tailwindcss.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">

    <!-- Lucide Icons -->
    <script src="{{ asset('vendor/lucide/lucide.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>

    <!-- jQuery UI for sortable -->
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>

    <style>
        [x-cloak] { display: none !important; }

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark-scrollbar::-webkit-scrollbar-thumb { background: #475569; }
        .dark-scrollbar::-webkit-scrollbar-thumb:hover { background: #64748b; }

        /* Sidebar gradient accent */
        .sidebar-gradient {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        }

        .sidebar-active-item {
            background: linear-gradient(135deg, rgba(59,130,246,0.15) 0%, rgba(139,92,246,0.1) 100%);
            border-left: 3px solid #3b82f6;
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.05);
        }

        /* Stat card gradient backgrounds */
        .stat-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .stat-emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-violet { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .stat-amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .stat-rose { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
        .stat-cyan { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }

        /* DataTable custom */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            background: white;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        table.dataTable tbody tr {
            transition: background-color 0.15s ease;
        }
        table.dataTable tbody tr:hover {
            background-color: #f8fafc !important;
        }
        table.dataTable thead th {
            border-bottom: 2px solid #e2e8f0 !important;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 0.875rem;
            color: #64748b;
            padding-top: 0;
        }
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.25rem;
            float: none;
            width: auto;
            padding-top: 0;
            white-space: normal;
        }
        .dataTables_wrapper .dataTables_paginate > span {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            margin: 0 !important;
            padding: 0 0.625rem !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            color: #475569 !important;
            background: #ffffff !important;
            font-size: 0.875rem;
            line-height: 1;
            box-shadow: none !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border-color: #bfdbfe !important;
            color: #2563eb !important;
            background: #eff6ff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            border-color: #2563eb !important;
            color: #ffffff !important;
            background: #2563eb !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            border-color: #e2e8f0 !important;
            color: #cbd5e1 !important;
            background: #f8fafc !important;
            cursor: not-allowed;
        }
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                width: 100%;
                justify-content: center;
                text-align: center;
            }
        }

        /* Modal backdrop */
        .modal-backdrop {
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
        }

        /* Pulse dot animation */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }

        /* Drag handle */
        .drag-handle { cursor: grab; }
        .drag-handle:active { cursor: grabbing; }
        .ui-sortable-helper { background: #eff6ff !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 0.5rem; }
        .ui-sortable-placeholder { background: #eff6ff; border: 2px dashed #93c5fd; border-radius: 0.5rem; visibility: visible !important; height: 48px; }

        /* Toast animation */
        @keyframes slide-in-right {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slide-out-right {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .toast-enter { animation: slide-in-right 0.3s ease-out; }
        .toast-exit { animation: slide-out-right 0.3s ease-in; }

        /* Mobile sidebar overlay */
        .sidebar-overlay {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(2px);
        }

        .select2-container--default .select2-selection--single {
            min-height: 42px;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            max-width: 100%;
        }
        .select2-container {
            max-width: 100%;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #334155;
            font-size: 0.875rem;
            line-height: 42px;
            padding-left: 1rem;
            padding-right: 2.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
            right: 0.625rem;
        }
        .select2-dropdown {
            border-color: #e2e8f0;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12);
            max-width: calc(100vw - 2rem);
        }
        .select2-results__option {
            overflow-wrap: anywhere;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            outline: none;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-900">
    <div x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        mobileSidebar: false,
        searchOpen: false,
        toasts: [],
        addToast(msg, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, msg, type });
            setTimeout(() => this.removeToast(id), 4000);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }" x-init="window.addEventListener('resize', () => { if (window.innerWidth >= 1024) mobileSidebar = false; })"
    class="flex h-full">

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="mobileSidebar" x-cloak
             @click="mobileSidebar = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 sidebar-overlay lg:hidden"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 flex flex-col sidebar-gradient text-white transition-all duration-300 shadow-xl"
            :class="{
                'w-64': sidebarOpen || mobileSidebar,
                'w-0 lg:w-20 overflow-hidden': !sidebarOpen && !mobileSidebar,
                'translate-x-0': mobileSidebar,
                '-translate-x-full lg:translate-x-0': !mobileSidebar
            }"
            x-cloak
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-slate-700/50 flex-shrink-0">
                <a href="/dashboard" class="flex items-center space-x-3 min-w-0">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-violet-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/25">
                        <span class="text-white font-bold text-sm">CL</span>
                    </div>
                    <span class="text-lg font-bold tracking-tight truncate" x-show="sidebarOpen || mobileSidebar" x-transition>CpitalLive</span>
                </a>
                <button @click="if(window.innerWidth < 1024) mobileSidebar = false; else sidebarOpen = false;"
                        class="p-1.5 rounded-lg hover:bg-slate-700/50 transition-colors lg:flex hidden"
                        x-show="sidebarOpen">
                    <i data-lucide="panel-left-close" class="w-4 h-4"></i>
                </button>
                <button @click="mobileSidebar = false"
                        class="p-1.5 rounded-lg hover:bg-slate-700/50 transition-colors lg:hidden">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 dark-scrollbar" x-show="sidebarOpen || mobileSidebar">
                @php
                    $menuTree = \App\Models\Menu::getMenuTree();
                @endphp

                <div class="space-y-1">
                    @foreach ($menuTree as $menu)
                        @php
                            $menuUrl = $menu->resolved_url ?? $menu->url;
                            $menuIsActive = filled($menu->route_name)
                                ? request()->routeIs($menu->route_name)
                                : filled($menuUrl) && request()->is(ltrim($menuUrl, '/') . '*');
                            $menuHasActiveChild = collect($menu->activeChildren)->contains(function ($child) {
                                $childUrl = $child->resolved_url ?? $child->url;

                                return filled($child->route_name)
                                    ? request()->routeIs($child->route_name)
                                    : filled($childUrl) && request()->is(ltrim($childUrl, '/') . '*');
                            });
                            $menuShouldOpen = $menuIsActive || $menuHasActiveChild;
                        @endphp

                        @if ($menu->activeChildren->count() > 0)
                            <!-- Parent with children -->
                            <div x-data="{ open: {{ $menuShouldOpen ? 'true' : 'false' }} }" class="mb-0.5">
                                <button
                                    @click="open = !open"
                                    class="flex items-center w-full px-3 py-2.5 text-sm rounded-xl hover:bg-slate-700/50 transition-all duration-200 text-slate-300 hover:text-white group"
                                >
                                    <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                                        <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-[18px] h-[18px]"></i>
                                    </span>
                                    <span class="ml-3 flex-1 text-left font-medium" x-show="sidebarOpen || mobileSidebar">{{ $menu->name }}</span>
                                    <svg
                                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                                        :class="open ? 'rotate-180' : ''"
                                        x-show="sidebarOpen || mobileSidebar"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open && (sidebarOpen || mobileSidebar)" x-collapse class="ml-5 mt-1 space-y-0.5 border-l border-slate-700/50 pl-3">
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
                                                <span x-show="sidebarOpen || mobileSidebar">{{ $child->name }}</span>
                                            </a>
                                        @else
                                            <span class="flex items-center px-3 py-2 text-sm rounded-lg text-slate-500">
                                                <span class="mr-2.5 flex-shrink-0">
                                                    <i data-lucide="{{ $child->icon ?? 'circle' }}" class="w-4 h-4"></i>
                                                </span>
                                                <span x-show="sidebarOpen || mobileSidebar">{{ $child->name }}</span>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Single menu item -->
                            @if (filled($menuUrl))
                                <a
                                    href="{{ $menuUrl }}"
                                    class="flex items-center px-3 py-2.5 mb-0.5 text-sm rounded-xl transition-all duration-200 {{ $menuIsActive ? 'sidebar-active-item text-blue-400 font-medium bg-slate-700/30' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}"
                                >
                                    <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                                        <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-[18px] h-[18px]"></i>
                                    </span>
                                    <span class="ml-3 font-medium" x-show="sidebarOpen || mobileSidebar">{{ $menu->name }}</span>
                                </a>
                            @else
                                <span class="flex items-center px-3 py-2.5 mb-0.5 text-sm rounded-xl text-slate-400">
                                    <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                                        <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-[18px] h-[18px]"></i>
                                    </span>
                                    <span class="ml-3 font-medium" x-show="sidebarOpen || mobileSidebar">{{ $menu->name }}</span>
                                </span>
                            @endif
                        @endif
                    @endforeach
                </div>
            </nav>

            <!-- Sidebar Toggle (Desktop) -->
            <div class="p-3 border-t border-slate-700/50 flex-shrink-0" x-show="sidebarOpen || mobileSidebar">
                <button
                    @click="if(window.innerWidth < 1024) mobileSidebar = false; else sidebarOpen = !sidebarOpen;"
                    class="flex items-center w-full px-3 py-2 text-sm rounded-xl hover:bg-slate-700/50 transition-colors text-slate-400 hover:text-white"
                >
                    <i data-lucide="panel-left-open" class="w-4 h-4"></i>
                    <span class="ml-3" x-show="sidebarOpen || mobileSidebar">Collapse</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-full transition-all duration-300" :class="{
            'lg:ml-64': sidebarOpen,
            'lg:ml-20': !sidebarOpen,
            'ml-0': true
        }">

            <!-- Top Navbar -->
            <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <!-- Left: hamburger + breadcrumb -->
                    <div class="flex items-center space-x-3">
                        <button @click="if(window.innerWidth < 1024) mobileSidebar = !mobileSidebar; else sidebarOpen = !sidebarOpen;"
                                class="p-2 rounded-lg hover:bg-slate-100 transition-colors text-slate-500">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>

                        <div class="hidden sm:flex items-center space-x-2 text-sm">
                            <a href="/dashboard" class="text-slate-400 hover:text-slate-600 transition-colors">
                                <i data-lucide="home" class="w-4 h-4"></i>
                            </a>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
                            <span class="font-medium text-slate-700">@yield('title', 'Dashboard')</span>
                        </div>
                    </div>

                    <!-- Right: search, notifications, user -->
                    <div class="flex items-center space-x-2">
                        <!-- Search -->
                        <button @click="searchOpen = !searchOpen" class="p-2 rounded-lg hover:bg-slate-100 transition-colors text-slate-500">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>

                        <!-- Notifications -->
                        <button class="p-2 rounded-lg hover:bg-slate-100 transition-colors text-slate-500 relative">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full pulse-dot"></span>
                        </button>

                        <!-- Divider -->
                        <div class="h-8 w-px bg-slate-200 mx-1 hidden sm:block"></div>

                        <!-- User Dropdown -->
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2.5 p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-violet-600 rounded-lg flex items-center justify-center text-white font-semibold text-xs shadow-sm">
                                    {{ Auth::user()->initials ?? strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-slate-700 leading-tight">{{ Auth::user()->name ?? 'User' }}</p>
                                    <p class="text-[11px] text-slate-400 leading-tight">{{ Auth::user()->role_badge['label'] ?? ucfirst(Auth::user()->role ?? 'User') }}</p>
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 hidden md:block"></i>
                            </button>

                            <div
                                x-show="dropdownOpen"
                                @click.away="dropdownOpen = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1.5 z-50"
                            >
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'User' }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ Auth::user()->email ?? '' }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                                    <i data-lucide="user" class="w-4 h-4 mr-2.5 text-slate-400"></i> Profile Settings
                                </a>
                                @if (Auth::user()?->isAdmin())
                                    <a href="{{ route('admin.menus.index') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                                        <i data-lucide="settings" class="w-4 h-4 mr-2.5 text-slate-400"></i> Settings
                                    </a>
                                @endif
                                <div class="border-t border-slate-100 my-1.5"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-2.5"></i> Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Bar (expandable) -->
                <div x-show="searchOpen" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="border-t border-slate-100 px-4 py-3 bg-white">
                    <div class="max-w-2xl mx-auto relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" placeholder="Search CIF, polis, aplikasi..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                               autofocus>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show"
                         x-init="setTimeout(() => { show = false }, 5000)"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex justify-between items-center shadow-sm">
                        <div class="flex items-center">
                            <i data-lucide="check-circle-2" class="w-5 h-5 mr-2.5 text-emerald-500"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="p-1 rounded-lg hover:bg-emerald-100 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show"
                         x-init="setTimeout(() => { show = false }, 5000)"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl flex justify-between items-center shadow-sm">
                        <div class="flex items-center">
                            <i data-lucide="alert-circle" class="w-5 h-5 mr-2.5 text-rose-500"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="p-1 rounded-lg hover:bg-rose-100 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl shadow-sm">
                        <div class="flex items-center mb-2">
                            <i data-lucide="alert-triangle" class="w-5 h-5 mr-2.5 text-rose-500"></i>
                            <span class="text-sm font-semibold">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 ml-7">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Support both @yield and $slot (for <x-app-layout>) --}}
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>

            <!-- Footer -->
            <footer class="border-t border-slate-200 bg-white px-6 py-3">
                <div class="flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400">
                    <span>&copy; {{ date('Y') }} CpitalLive Individual. All rights reserved.</span>
                    <span class="mt-1 sm:mt-0">Version 1.0.0 &middot; Built with Laravel</span>
                </div>
            </footer>
        </div>

        <!-- Toast Container -->
        <div class="fixed bottom-4 right-4 z-[100] space-y-2" x-cloak>
            <template x-for="toast in toasts" :key="toast.id">
                <div class="toast-enter flex items-center p-4 rounded-xl shadow-lg border min-w-[300px]"
                     :class="{
                        'bg-emerald-50 border-emerald-200 text-emerald-700': toast.type === 'success',
                        'bg-rose-50 border-rose-200 text-rose-700': toast.type === 'error',
                        'bg-blue-50 border-blue-200 text-blue-700': toast.type === 'info'
                     }">
                    <span x-text="toast.msg" class="text-sm font-medium flex-1"></span>
                    <button @click="removeToast(toast.id)" class="ml-3 p-1 rounded-lg hover:bg-black/5">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </template>
        </div>
    </div>

    <script>
        window.initEnhancedSelects = function (scope = document) {
            if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') return;

            $(scope).find('select.js-enhanced-select').each(function () {
                if ($(this).hasClass('select2-hidden-accessible')) return;

                const dropdownParent = $(this).closest('[data-select2-parent]').length
                    ? $(this).closest('[data-select2-parent]')
                    : $(this).closest('.modal-backdrop').length
                    ? $(this).closest('.modal-backdrop')
                    : $(document.body);

                $(this).select2({
                    width: '100%',
                    dropdownParent,
                    allowClear: $(this).find('option[value=""]').length > 0,
                    placeholder: $(this).data('placeholder') || 'Select an option',
                });
            });
        };

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
            if (typeof window.initEnhancedSelects === 'function') window.initEnhancedSelects();
        });
        // Re-init after Alpine updates
        document.addEventListener('alpine:initialized', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
            if (typeof window.initEnhancedSelects === 'function') window.initEnhancedSelects();
        });
    </script>

    @stack('scripts')
</body>
</html>
