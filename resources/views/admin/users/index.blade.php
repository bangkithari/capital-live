@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 lg:p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i data-lucide="users" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Users
                </h2>
                <p class="text-sm text-slate-400 mt-0.5">Manage administrator, manager, agent, and user accounts.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i> Add User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/80">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Department</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-violet-600 rounded-lg flex items-center justify-center text-white text-xs font-bold mr-3">
                                        {{ $user->initials }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $user->user_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full border {{ $user->role_badge['bg'] }}">
                                    {{ $user->role_badge['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600">{{ $user->department->name ?? "-" }}</td>
                            <td class="px-5 py-4 text-center">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-emerald-600 bg-emerald-50 rounded-full border border-emerald-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-slate-500 bg-slate-100 rounded-full border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                       title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                                                title="Delete"
                                                @disabled(auth()->id() === $user->id)>
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
