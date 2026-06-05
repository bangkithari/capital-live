@extends('layouts.app')

@section('title', 'Role Access')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 lg:p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i data-lucide="shield" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Role Access
                </h2>
                <p class="text-sm text-slate-400 mt-0.5">Control which roles can see each sidebar menu item.</p>
            </div>
            <a href="{{ route('admin.menus.index') }}"
               class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                <i data-lucide="layout-list" class="w-4 h-4 mr-2"></i> Menu Management
            </a>
        </div>

        <form action="{{ route('admin.role-access.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider min-w-[260px]">Menu</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">All Roles</th>
                            @foreach ($roles as $role)
                                <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ ucfirst($role->name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($menus as $menu)
                            @include('admin.role-access.partials.row', ['menu' => $menu, 'roles' => $roles, 'isChild' => false])

                            @foreach ($menu->children->sortBy('sort_order') as $child)
                                @include('admin.role-access.partials.row', ['menu' => $child, 'roles' => $roles, 'isChild' => true])
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between gap-3">
                <p class="text-xs text-slate-400">
                    Empty menu type means public menu. Admin routes still require admin access even if a menu is made visible.
                </p>
                <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Access
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.js-role-public').forEach((checkbox) => {
        const syncRow = () => {
            const roleInputs = document.querySelectorAll(`.js-role-access[data-menu-id="${checkbox.dataset.menuId}"]`);
            roleInputs.forEach((input) => {
                input.disabled = checkbox.checked;
                if (checkbox.checked) input.checked = false;
            });
        };

        checkbox.addEventListener('change', syncRow);
        syncRow();
    });
});
</script>
@endpush
