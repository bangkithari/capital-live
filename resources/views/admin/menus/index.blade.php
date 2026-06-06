@extends('layouts.app')

@section('title', 'Menu Management')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="menuManager()">
        <!-- Header -->
        <div class="p-5 lg:p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i data-lucide="layout-list" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Menu Structure
                </h2>
                <p class="text-sm text-slate-400 mt-0.5">Drag to reorder. Toggle active status. Click edit to modify.</p>
            </div>
            <div class="flex items-center space-x-2">
                <button @click="saveOrder()" x-show="hasOrderChanged"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 transition-all shadow-md shadow-emerald-500/20">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Order
                </button>
                <button @click="openCreateModal()"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20 hover:shadow-lg">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Menu
                </button>
            </div>
        </div>

        <!-- Menu Table -->
        <div class="overflow-x-auto">
            <table class="w-full" id="menus-table">
                <thead>
                    <tr class="bg-slate-50/80">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-10"></th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">Icon</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name / Code</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">URL</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Handler / Type</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-20">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-32">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-parent" class="divide-y divide-slate-100">
                    @foreach ($menus as $index => $menu)
                        <tr class="group hover:bg-blue-50/30 transition-colors sortable-item" data-id="{{ $menu->id }}">
                            <td class="px-5 py-3 drag-handle">
                                <i data-lucide="grip-vertical" class="w-4 h-4 text-slate-300 group-hover:text-slate-500 transition-colors cursor-grab"></i>
                            </td>
                            <td class="px-5 py-3 text-sm text-slate-400 font-mono">{{ $menu->sort_order }}</td>
                            <td class="px-5 py-3">
                                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="{{ $menu->icon ?? 'circle' }}" class="w-4 h-4 text-slate-500"></i>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm font-semibold text-slate-700">{{ $menu->name }}</span>
                                <div class="text-xs text-slate-400 font-mono">{{ $menu->code }}</div>
                            </td>
                            <td class="px-5 py-3">
                                <code class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-md font-mono">{{ $menu->url ?? '—' }}</code>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-xs text-slate-500">{{ $menu->controller ?? '—' }}{{ $menu->action ? '@'.$menu->action : '' }}</span>
                                <div class="text-xs text-slate-400">{{ $menu->menu_type ?? 'public' }}</div>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($menu->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <button x-on:click="editMenu('{{ $menu->hashid }}')"
                                            class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                            title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="deleteMenu('{{ $menu->hashid }}', '{{ addslashes($menu->name) }}')"
                                            class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                                            title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Children rows --}}
                        @foreach ($menu->children->sortBy('sort_order') as $child)
                            <tr class="group hover:bg-violet-50/30 transition-colors bg-slate-50/50 sortable-child" data-id="{{ $child->id }}" data-parent="{{ $menu->id }}">
                                <td class="px-5 py-2.5 drag-handle pl-10">
                                    <i data-lucide="grip-vertical" class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500 transition-colors cursor-grab"></i>
                                </td>
                                <td class="px-5 py-2.5 text-sm text-slate-300 font-mono text-xs">{{ $child->sort_order }}</td>
                                <td class="px-5 py-2.5">
                                    <div class="w-7 h-7 bg-violet-50 rounded-lg flex items-center justify-center">
                                        <i data-lucide="{{ $child->icon ?? 'circle' }}" class="w-3.5 h-3.5 text-violet-400"></i>
                                    </div>
                                </td>
                                <td class="px-5 py-2.5">
                                    <span class="text-sm text-slate-600 flex items-center">
                                        <span class="w-4 h-px bg-slate-300 mr-2"></span>
                                        {{ $child->name }}
                                    </span>
                                    <div class="text-xs text-slate-400 font-mono pl-6">{{ $child->code }}</div>
                                </td>
                                <td class="px-5 py-2.5">
                                    <code class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md font-mono">{{ $child->url ?? '—' }}</code>
                                </td>
                                <td class="px-5 py-2.5">
                                    <span class="text-xs text-slate-500">{{ $child->controller ?? '—' }}{{ $child->action ? '@'.$child->action : '' }}</span>
                                    <div class="text-xs text-slate-400">{{ $child->menu_type ?? 'public' }}</div>
                                </td>
                                <td class="px-5 py-2.5 text-center">
                                    @if($child->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-5 py-2.5 text-right">
                                    <div class="flex items-center justify-end space-x-1">
                                        <button x-on:click="editMenu('{{ $child->hashid }}')"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                                title="Edit">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </button>
                                        <button @click="deleteMenu('{{ $child->hashid }}', '{{ addslashes($child->name) }}')"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                                                title="Delete">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($menus->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="layout-list" class="w-8 h-8 text-slate-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-600 mb-1">No menu items yet</h3>
                <p class="text-sm text-slate-400 mb-4">Create your first menu item to get started.</p>
                <button @click="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Menu Item
                </button>
            </div>
        @endif

        {{-- ===================== CREATE / EDIT MODAL ===================== --}}
        <div x-show="showModal" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[90] flex items-center justify-center p-4 modal-backdrop"
             @click.self="showModal = false">

            <div x-show="showModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
                 data-select2-parent>

                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-2.5"
                             :class="editMode ? 'bg-amber-100' : 'bg-blue-100'">
                            <i :data-lucide="editMode ? 'pencil' : 'plus'" class="w-4 h-4"
                               :class="editMode ? 'text-amber-600' : 'text-blue-600'"></i>
                        </div>
                        <span x-text="editMode ? 'Edit Menu Item' : 'Create Menu Item'"></span>
                    </h3>
                    <button @click="showModal = false" class="p-2 rounded-lg hover:bg-slate-100 transition-colors text-slate-400">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <form :action="editMode ? `/admin/menus/${form.hashid}` : '{{ route('admin.menus.store') }}'" method="POST" class="p-6 space-y-5">
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Menu Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="form.name" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                               placeholder="e.g. Dashboard">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Code <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" x-model="form.code" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all font-mono"
                               placeholder="e.g. dashboard">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">URL</label>
                        <input type="text" name="url" x-model="form.url"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all font-mono"
                               placeholder="e.g. /dashboard">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Icon (Lucide)</label>
                            <input type="text" name="icon" x-model="form.icon"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                                   placeholder="e.g. home, users, settings">
                            <p class="text-xs text-slate-400 mt-1">Lucide icon name</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Sort Order</label>
                            <input type="number" name="sort_order" x-model="form.sort_order" min="0"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Parent Menu</label>
                        <select name="parent_id" id="menu-parent-select" x-model="form.parent_id"
                                class="ui fluid search selection dropdown semantic-parent-menu">
                            <option value="">— Top Level —</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Controller</label>
                            <input type="text" name="controller" x-model="form.controller"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all font-mono"
                                   placeholder="e.g. MenuController">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Action</label>
                            <input type="text" name="action" x-model="form.action"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all font-mono"
                                   placeholder="e.g. index">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Param</label>
                            <input type="number" name="param" x-model="form.param"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Menu Type</label>
                            <input type="text" name="menu_type" x-model="form.menu_type"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                                   placeholder="e.g. admin">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Stored Procedure</label>
                        <input type="text" name="stored_procedure" x-model="form.stored_procedure"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all font-mono">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Params JSON</label>
                        <textarea name="params_json" x-model="form.params_json" rows="3"
                                  class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all font-mono"
                                  placeholder='{"key":"value"}'></textarea>
                    </div>

                    <div class="flex items-center">
                        <button type="button" @click="form.is_active = !form.is_active"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200"
                                :class="form.is_active ? 'bg-emerald-500' : 'bg-slate-300'">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                                  :class="form.is_active ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                        <input type="hidden" name="is_active" :value="form.is_active ? 1 : 0">
                        <label class="ml-2.5 text-sm font-medium text-slate-600">Active</label>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showModal = false"
                                class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20"
                                x-text="editMode ? 'Update Menu' : 'Create Menu'">
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== DELETE CONFIRM MODAL ===================== --}}
        <div x-show="showDeleteModal" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-[90] flex items-center justify-center p-4 modal-backdrop"
             @click.self="showDeleteModal = false">

            <div x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 text-center">
                <div class="w-14 h-14 bg-rose-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-triangle" class="w-7 h-7 text-rose-500"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Delete Menu Item?</h3>
                <p class="text-sm text-slate-500 mb-6">
                    Are you sure you want to delete "<span x-text="deleteTarget.name" class="font-semibold text-slate-700"></span>"?
                    This will also remove all child menu items.
                </p>
                <div class="flex items-center justify-center space-x-3">
                    <button @click="showDeleteModal = false"
                            class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                        Cancel
                    </button>
                    <form :action="`/admin/menus/${deleteTarget.hashid}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-5 py-2.5 bg-rose-600 text-white text-sm font-semibold rounded-xl hover:bg-rose-700 transition-colors shadow-md shadow-rose-500/20">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Store all menu data globally for edit modal
window.menuData = @json($menuData);

function menuManager() {
    return {
        showModal: false,
        showDeleteModal: false,
        editMode: false,
        hasOrderChanged: false,
        form: {
            id: null,
            name: '',
            url: '',
            code: '',
            controller: '',
            action: '',
            param: '',
            icon: '',
            menu_type: '',
            sort_order: 0,
            parent_id: '',
            stored_procedure: '',
            params_json: '',
            is_active: true,
        },
        deleteTarget: { id: null, name: '' },

        openCreateModal() {
            this.editMode = false;
            this.form = { id: null, name: '', code: '', url: '', controller: '', action: '', param: '', icon: '', menu_type: '', sort_order: 0, parent_id: '', stored_procedure: '', params_json: '', is_active: true };
            this.showModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
                initSemanticParentMenu();
                $('#menu-parent-select').dropdown('set selected', this.form.parent_id || '');
            });
        },

        editMenu(hashid) {
            var menu = window.menuData.find(function(m) { return m.hashid === hashid; });
            if (!menu) return;
            this.editMode = true;
            this.form = {
                id: menu.id,
                hashid: menu.hashid,
                name: menu.name || '',
                code: menu.code || '',
                url: menu.url || '',
                controller: menu.controller || '',
                action: menu.action || '',
                param: menu.param ?? '',
                icon: menu.icon || '',
                menu_type: menu.menu_type || '',
                sort_order: menu.sort_order ?? 0,
                parent_id: menu.parent_id || '',
                stored_procedure: menu.stored_procedure || '',
                params_json: menu.params_json || '',
                is_active: !!menu.is_active,
            };
            this.showModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
                initSemanticParentMenu();
                $('#menu-parent-select').dropdown('set selected', this.form.parent_id || '');
            });
        },

        deleteMenu(hashid, name) {
            this.deleteTarget = { hashid: hashid, name: name };
            this.showDeleteModal = true;
            this.$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
        },

        async saveOrder() {
            const items = [];
            document.querySelectorAll('#sortable-parent tr[data-id]').forEach((tr, idx) => {
                items.push({ id: tr.dataset.id, order: idx });
            });
            try {
                const resp = await fetch('/admin/menus/reorder', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ items }),
                });
                if (resp.ok) {
                    location.reload();
                }
            } catch (e) {
                console.error(e);
            }
        },

        init() {
            if (typeof $ !== 'undefined' && typeof $.fn.sortable !== 'undefined') {
                $('#sortable-parent').sortable({
                    handle: '.drag-handle',
                    placeholder: 'ui-sortable-placeholder',
                    opacity: 0.8,
                    cursor: 'grabbing',
                    tolerance: 'pointer',
                    update: () => { this.hasOrderChanged = true; },
                });
            }
        }
    };
}

function initSemanticParentMenu() {
    if (typeof $ === 'undefined' || typeof $.fn.dropdown === 'undefined') return;

    $('#menu-parent-select').dropdown({
        fullTextSearch: true,
        clearable: true,
        forceSelection: false,
        message: {
            noResults: 'No parent menu found.',
        },
        onChange(value) {
            const select = document.getElementById('menu-parent-select');
            if (select) {
                select.value = value;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') lucide.createIcons();
    initSemanticParentMenu();
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/semantic-ui/semantic.min.css') }}">
@endpush

@prepend('scripts')
<script src="{{ asset('vendor/semantic-ui/semantic.min.js') }}"></script>
@endprepend
