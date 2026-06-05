@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    {{-- Profile Header Card --}}
    <div class="bg-gradient-to-r from-blue-600 via-violet-600 to-purple-700 rounded-2xl p-6 lg:p-8 mb-6 relative overflow-hidden shadow-xl shadow-blue-500/10">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-1/3 w-40 h-40 bg-white/5 rounded-full translate-y-1/2"></div>

        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-5">
            <!-- Avatar -->
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-lg border-2 border-white/30">
                {{ $user->initials }}
            </div>

            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-1">
                    <h1 class="text-2xl lg:text-3xl font-bold text-white">{{ $user->name }}</h1>
                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full border {{ $user->role_badge['bg'] }}">
                        {{ $user->role_badge['label'] }}
                    </span>
                </div>
                <p class="text-blue-100 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $user->email }}
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="flex gap-4 sm:gap-6">
                <div class="text-center">
                    <p class="text-2xl font-bold text-white">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-blue-200">Total Users</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-white">{{ $stats['cif'] ?? 0 }}</p>
                    <p class="text-xs text-blue-200">CIF</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: User Info Card -->
        <div class="lg:col-span-1 space-y-6">

            <!-- User Details Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center">
                        <i data-lucide="user" class="w-4 h-4 mr-2 text-blue-500"></i>
                        User Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Name -->
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Full Name</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $user->name }}</span>
                    </div>
                    <!-- Email -->
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</span>
                        <span class="text-sm text-slate-600">{{ $user->email }}</span>
                    </div>
                    <!-- Role -->
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold rounded-full border {{ $user->role_badge['bg'] }}">
                            {{ $user->role_badge['label'] }}
                        </span>
                    </div>
                    <!-- Status -->
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</span>
                        @if($user->is_active)
                            <span class="inline-flex items-center text-xs font-semibold text-emerald-600">
                                <span class="w-2 h-2 bg-emerald-400 rounded-full mr-1.5"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center text-xs font-semibold text-rose-500">
                                <span class="w-2 h-2 bg-rose-400 rounded-full mr-1.5"></span> Inactive
                            </span>
                        @endif
                    </div>
                    <!-- Joined -->
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Joined</span>
                        <span class="text-sm text-slate-600">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <!-- Last Updated -->
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Last Updated</span>
                        <span class="text-sm text-slate-600">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Security Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center">
                        <i data-lucide="shield" class="w-4 h-4 mr-2 text-emerald-500"></i>
                        Security
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center p-3 bg-emerald-50 rounded-xl">
                        <i data-lucide="lock" class="w-4 h-4 text-emerald-500 mr-3"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-700">Password</p>
                            <p class="text-xs text-slate-400">Last changed {{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600">Strong</span>
                    </div>
                    <div class="flex items-center p-3 bg-blue-50 rounded-xl">
                        <i data-lucide="shield-check" class="w-4 h-4 text-blue-500 mr-3"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-700">JWT Auth</p>
                            <p class="text-xs text-slate-400">API token authentication enabled</p>
                        </div>
                        <span class="text-xs font-semibold text-blue-600">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Forms -->
        <div class="lg:col-span-2 space-y-6">

            {{-- Success Message --}}
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center shadow-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 mr-2.5 text-emerald-500"></i>
                    <span class="text-sm font-medium">Profile updated successfully!</span>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center shadow-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 mr-2.5 text-emerald-500"></i>
                    <span class="text-sm font-medium">Password changed successfully!</span>
                </div>
            @endif

            <!-- Edit Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center">
                        <i data-lucide="pencil" class="w-4 h-4 mr-2 text-blue-500"></i>
                        Edit Profile
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Update your account's profile information</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all @error('name') border-rose-300 @enderror">
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all @error('email') border-rose-300 @enderror">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Read-only fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role</label>
                            <div class="flex items-center px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold rounded-full border {{ $user->role_badge['bg'] }} mr-2">
                                    {{ $user->role_badge['label'] }}
                                </span>
                                <span class="text-xs text-slate-400">Assigned by admin</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Member Since</label>
                            <div class="flex items-center px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 mr-2"></i>
                                <span class="text-sm text-slate-600">{{ $user->created_at->format('F d, Y') }}</span>
                                <span class="text-xs text-slate-400 ml-2">({{ $user->created_at->diffForHumans() }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20 hover:shadow-lg">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center">
                        <i data-lucide="lock" class="w-4 h-4 mr-2 text-amber-500"></i>
                        Change Password
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Ensure your account is using a long, random password</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Current Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-lucide="key" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <input type="password" id="current_password" name="current_password"
                                   class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all @error('current_password', 'updatePassword') border-rose-300 @enderror"
                                   placeholder="Enter current password">
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">New Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="password" id="password" name="password"
                                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all @error('password', 'updatePassword') border-rose-300 @enderror"
                                       placeholder="••••••••">
                            </div>
                            @error('password', 'updatePassword')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 transition-all shadow-md shadow-amber-500/20 hover:shadow-lg">
                            <i data-lucide="key" class="w-4 h-4 mr-2"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-rose-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-rose-100 bg-rose-50/50">
                    <h3 class="text-sm font-bold text-rose-700 flex items-center">
                        <i data-lucide="alert-triangle" class="w-4 h-4 mr-2 text-rose-500"></i>
                        Danger Zone
                    </h3>
                    <p class="text-xs text-rose-400 mt-0.5">Irreversible actions — proceed with caution</p>
                </div>

                <div class="p-6">
                    <div class="flex items-center justify-between p-4 bg-rose-50 rounded-xl border border-rose-100">
                        <div>
                            <p class="text-sm font-semibold text-rose-700">Delete Account</p>
                            <p class="text-xs text-rose-400 mt-0.5">Permanently delete your account and all data</p>
                        </div>
                        <form method="POST" action="{{ route('profile.destroy') }}"
                              onsubmit="return confirm('Are you absolutely sure? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-rose-600 text-white text-xs font-semibold rounded-lg hover:bg-rose-700 transition-colors shadow-sm">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
