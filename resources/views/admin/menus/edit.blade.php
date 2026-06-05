@extends('layouts.app')

@section('title', 'Edit Menu Item')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Edit Menu Item: {{ $menu->name }}</h2>
            </div>

            <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code', $menu->code) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <input type="text" name="url" id="url" value="{{ old('url', $menu->url) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    @error('url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $menu->icon) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $menu->sort_order) }}" min="0"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Menu</label>
                    <select name="parent_id" id="parent_id"
                            class="ui fluid search selection dropdown semantic-parent-menu">
                        <option value="">Top Level</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="controller" class="block text-sm font-medium text-gray-700 mb-1">Controller</label>
                        <input type="text" name="controller" id="controller" value="{{ old('controller', $menu->controller) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">
                    </div>

                    <div>
                        <label for="action" class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                        <input type="text" name="action" id="action" value="{{ old('action', $menu->action) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="param" class="block text-sm font-medium text-gray-700 mb-1">Param</label>
                        <input type="number" name="param" id="param" value="{{ old('param', $menu->param) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    <div>
                        <label for="menu_type" class="block text-sm font-medium text-gray-700 mb-1">Menu Type</label>
                        <input type="text" name="menu_type" id="menu_type" value="{{ old('menu_type', $menu->menu_type) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <div>
                    <label for="stored_procedure" class="block text-sm font-medium text-gray-700 mb-1">Stored Procedure</label>
                    <input type="text" name="stored_procedure" id="stored_procedure" value="{{ old('stored_procedure', $menu->stored_procedure) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">
                </div>

                <div>
                    <label for="params_json" class="block text-sm font-medium text-gray-700 mb-1">Params JSON</label>
                    <textarea name="params_json" id="params_json" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono"
                              placeholder='{"key":"value"}'>{{ old('params_json', $menu->params_json) }}</textarea>
                    @error('params_json')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                </div>

                <div class="flex items-center space-x-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Update Menu Item
                    </button>
                    <a href="{{ route('admin.menus.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/semantic-ui/semantic.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('vendor/semantic-ui/semantic.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof $ !== 'undefined' && typeof $.fn.dropdown !== 'undefined') {
        $('#parent_id').dropdown({
            fullTextSearch: true,
            clearable: true,
            forceSelection: false,
            message: {
                noResults: 'No parent menu found.',
            },
        });
    }
});
</script>
@endpush
