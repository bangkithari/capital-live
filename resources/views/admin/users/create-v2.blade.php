@extends('layouts.app')

@section('title', 'Create User v2')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-800 flex items-center">
                <i data-lucide="user-plus" class="w-5 h-5 mr-2 text-blue-500"></i>
                Create User <span class="ml-2 text-xs font-medium px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full">v2 Ajax</span>
            </h2>
        </div>

        <form id="createUserForm" class="p-6 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                <p class="mt-1 text-sm text-rose-500 hidden" data-error="name"></p>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                <p class="mt-1 text-sm text-rose-500 hidden" data-error="email"></p>
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <p class="mt-1 text-sm text-rose-500 hidden" data-error="password"></p>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>
            </div>

            {{-- Role & Department --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-rose-500">*</span></label>
                    <select name="role" id="role" required
                            class="js-enhanced-select w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-rose-500 hidden" data-error="role"></p>
                </div>
                <div>
                    <label for="department_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Department <span class="text-rose-500">*</span></label>
                    <select name="department_id" id="department_id" required
                            class="js-enhanced-select w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }} ({{ $dept->code }})</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-rose-500 hidden" data-error="department_id"></p>
                </div>
            </div>

            {{-- Active --}}
            <div class="flex items-center">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                       class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <label for="is_active" class="ml-2.5 text-sm font-medium text-slate-600">Active</label>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center space-x-3 pt-4 border-t border-slate-100">
                <button type="submit" id="btnSubmit"
                        class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                    <span id="btnText">Create User</span>
                    <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                    Cancel
                </a>
            </div>

            {{-- Global error --}}
            <div id="globalError" class="hidden p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm text-rose-700"></div>
            {{-- Success --}}
            <div id="successMsg" class="hidden p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700"></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var $form    = $('#createUserForm');
    var $btn     = $('#btnSubmit');
    var $text    = $('#btnText');
    var $spinner = $('#btnSpinner');
    var $global  = $('#globalError');
    var $success = $('#successMsg');

    function setLoading(on) {
        $btn.prop('disabled', on);
        $text.text(on ? 'Saving...' : 'Create User');
        $spinner.toggleClass('hidden', !on);
    }

    function clearErrors() {
        $form.find('[data-error]').each(function() {
            $(this).addClass('hidden').text('');
        });
        $global.addClass('hidden').text('');
        $success.addClass('hidden').text('');
    }

    function showFieldErrors(errors) {
        $.each(errors, function(field, messages) {
            var $el = $form.find('[data-error="' + field + '"]');
            if ($el.length) {
                $el.removeClass('hidden').text(messages[0]);
            }
        });
    }

    $form.on('submit', function(e) {
        e.preventDefault();
        clearErrors();
        setLoading(true);

        var payload = {
            name:           $form.find('[name=name]').val(),
            email:          $form.find('[name=email]').val(),
            password:       $form.find('[name=password]').val(),
            password_confirmation: $form.find('[name=password_confirmation]').val(),
            role:           $form.find('[name=role]').val(),
            department_id:  $form.find('[name=department_id]').val(),
            is_active:      $form.find('[name=is_active]').is(':checked'),
        };

        $.ajax({
            url:         '{{ route("admin.users.store-v2") }}',
            type:        'POST',
            data:        JSON.stringify(payload),
            dataType:    'json',
            contentType: 'application/json',
            headers:     {
                'Accept':       'application/json',
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
            },
            success: function(res) {
                setLoading(false);
                $success.removeClass('hidden').text(res.message || 'User created!');
                $form[0].reset();
                $form.find('[name=is_active]').prop('checked', true);
            },
            error: function(xhr) {
                setLoading(false);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    showFieldErrors(xhr.responseJSON.errors);
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    $global.removeClass('hidden').text(xhr.responseJSON.message);
                } else {
                    $global.removeClass('hidden').text('Something went wrong. Please try again.');
                }
            }
        });
    });
});
</script>
@endpush
