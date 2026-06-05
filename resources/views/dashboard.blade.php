@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="mb-6 bg-gradient-to-r from-blue-600 via-violet-600 to-purple-700 rounded-2xl p-6 lg:p-8 text-white shadow-xl shadow-blue-500/10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-1/2 w-40 h-40 bg-white/5 rounded-full translate-y-1/2"></div>
        <div class="relative z-10">
            <h1 class="text-2xl lg:text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name ?? 'User' }}!</h1>
            <p class="text-blue-100 text-sm lg:text-base max-w-xl">Here's what's happening with CIF, polis, and aplikasi data today.</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">

        <!-- CIF Card -->
        <div class="card-hover bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 stat-blue rounded-full opacity-10 -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 stat-blue rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i data-lucide="users" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
                </div>
                <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['cif'] ?? 0 }}</p>
                <p class="text-sm text-slate-500 font-medium">Total CIF</p>
                <a href="{{ route('cif.index') }}" class="inline-flex items-center mt-3 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    View all <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Policies Card -->
        <div class="card-hover bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 stat-emerald rounded-full opacity-10 -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 stat-emerald rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i data-lucide="file-text" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">Active</span>
                </div>
                <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['polis'] ?? 0 }}</p>
                <p class="text-sm text-slate-500 font-medium">Polis</p>
                <span class="inline-flex items-center mt-3 text-xs text-slate-400">From polis table</span>
            </div>
        </div>

        <!-- Appointments Card -->
        <div class="card-hover bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 stat-violet rounded-full opacity-10 -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 stat-violet rounded-xl flex items-center justify-center shadow-lg shadow-violet-500/20">
                        <i data-lucide="calendar" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold text-violet-600 bg-violet-50 px-2 py-1 rounded-lg">Scheduled</span>
                </div>
                <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['aplikasi'] ?? 0 }}</p>
                <p class="text-sm text-slate-500 font-medium">Aplikasi</p>
                <span class="inline-flex items-center mt-3 text-xs text-slate-400">From aplikasi table</span>
            </div>
        </div>

        <!-- Agents Card -->
        <div class="card-hover bg-white rounded-2xl shadow-sm border border-slate-100 p-5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 stat-amber rounded-full opacity-10 -translate-y-8 translate-x-8 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 stat-amber rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <i data-lucide="shield-check" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">Licensed</span>
                </div>
                <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['users'] ?? 0 }}</p>
                <p class="text-sm text-slate-500 font-medium">Users</p>
                <span class="inline-flex items-center mt-3 text-xs text-slate-400">Active system accounts</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions + Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mb-6">

        <!-- Quick Actions -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Quick Actions</h2>
                    <p class="text-sm text-slate-400 mt-0.5">Frequently used shortcuts</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('cif.index') }}" class="group flex flex-col items-center p-4 bg-slate-50 rounded-xl hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all duration-200">
                    <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center mb-2 transition-colors">
                        <i data-lucide="user-plus" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 group-hover:text-blue-700 text-center transition-colors">CIF List</span>
                </a>

                <a href="#" class="group flex flex-col items-center p-4 bg-slate-50 rounded-xl hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition-all duration-200">
                    <div class="w-10 h-10 bg-emerald-100 group-hover:bg-emerald-200 rounded-xl flex items-center justify-center mb-2 transition-colors">
                        <i data-lucide="file-plus" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 group-hover:text-emerald-700 text-center transition-colors">Polis</span>
                </a>

                <a href="#" class="group flex flex-col items-center p-4 bg-slate-50 rounded-xl hover:bg-violet-50 border border-transparent hover:border-violet-100 transition-all duration-200">
                    <div class="w-10 h-10 bg-violet-100 group-hover:bg-violet-200 rounded-xl flex items-center justify-center mb-2 transition-colors">
                        <i data-lucide="calendar-plus" class="w-5 h-5 text-violet-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 group-hover:text-violet-700 text-center transition-colors">Aplikasi</span>
                </a>

                @if (Auth::user()?->isAdmin())
                    <a href="{{ route('admin.menus.index') }}" class="group flex flex-col items-center p-4 bg-slate-50 rounded-xl hover:bg-slate-100 border border-transparent hover:border-slate-200 transition-all duration-200">
                        <div class="w-10 h-10 bg-slate-200 group-hover:bg-slate-300 rounded-xl flex items-center justify-center mb-2 transition-colors">
                            <i data-lucide="settings" class="w-5 h-5 text-slate-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-600 text-center transition-colors">Admin</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Recent Activity</h2>
                    <p class="text-sm text-slate-400 mt-0.5">Latest updates</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="user-plus" class="w-4 h-4 text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">CIF records synchronized</p>
                        <p class="text-xs text-slate-400 mt-0.5">2 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">Polis data available</p>
                        <p class="text-xs text-slate-400 mt-0.5">15 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="calendar" class="w-4 h-4 text-violet-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">Aplikasi data available</p>
                        <p class="text-xs text-slate-400 mt-0.5">1 hour ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-amber-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">Policy renewal due</p>
                        <p class="text-xs text-slate-400 mt-0.5">3 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Management Quick Access -->
    @if (Auth::user()?->isAdmin())
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Menu Management</h2>
                <p class="text-sm text-slate-400 mt-0.5">Configure sidebar navigation dynamically</p>
            </div>
            <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30">
                <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Manage Menus
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php $menuTree = \App\Models\Menu::getMenuTree(); @endphp
            @foreach ($menuTree->take(6) as $menu)
                <div class="flex items-center p-3 bg-slate-50 rounded-xl">
                    <div class="w-9 h-9 bg-white rounded-lg border border-slate-200 flex items-center justify-center mr-3">
                        <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-4 h-4 text-slate-500"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-700 truncate">{{ $menu->name }}</p>
                        <p class="text-xs text-slate-400">{{ $menu->activeChildren->count() }} sub-menus</p>
                    </div>
                    @if($menu->is_active)
                        <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    @else
                        <span class="w-2 h-2 bg-slate-300 rounded-full"></span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection
