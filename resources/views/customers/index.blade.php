@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <!-- Header -->
        <div class="p-5 lg:p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i data-lucide="users" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Customer Directory
                </h2>
                <p class="text-sm text-slate-400 mt-0.5">Manage all your customers in one place</p>
            </div>
            <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20 hover:shadow-lg">
                <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i> Add Customer
            </a>
        </div>

        <!-- Table -->
        <div class="p-5 lg:p-6">
            <table id="customers-table" class="w-full text-sm text-left display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider">Type</th>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider">Name</th>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider">Email</th>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider">Phone</th>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider">Status</th>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider">Created</th>
                        <th class="pb-3 font-semibold text-slate-500 uppercase text-xs tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{ route("customers.list") }}',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 0, name: 'type', width: '8%' },
            { data: 1, name: 'first_name', width: '20%' },
            { data: 2, name: 'email', width: '20%' },
            { data: 3, name: 'phone_cell', width: '14%' },
            { data: 4, name: 'is_active', width: '10%', orderable: false, searchable: false },
            { data: 5, name: 'created_at', width: '13%' },
            { data: 6, name: 'actions', orderable: false, searchable: false, width: '15%' },
        ],
        order: [[5, 'desc']],
        pageLength: 25,
        language: {
            processing: '<div class="flex items-center justify-center py-8"><svg class="animate-spin h-6 w-6 text-blue-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span class="text-sm text-slate-500 font-medium">Loading customers...</span></div>',
            emptyTable: '<div class="py-8"><div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3"><i data-lucide="users" class="w-7 h-7 text-slate-300"></i></div><p class="text-sm text-slate-500 font-medium">No customers found</p><p class="text-xs text-slate-400 mt-1">Create your first customer to get started</p></div>',
            zeroRecords: '<div class="py-8"><p class="text-sm text-slate-500">No matching customers found</p></div>',
            info: 'Showing _START_ to _END_ of _TOTAL_ customers',
            infoEmpty: 'No customers',
            infoFiltered: '(filtered from _total_)',
            lengthMenu: 'Show _MENU_ per page',
            search: '<i data-lucide="search" class="w-4 h-4 inline mr-1"></i>',
            paginate: {
                first: '<i data-lucide="chevrons-left" class="w-4 h-4"></i>',
                last: '<i data-lucide="chevrons-right" class="w-4 h-4"></i>',
                next: '<i data-lucide="chevron-right" class="w-4 h-4"></i>',
                previous: '<i data-lucide="chevron-left" class="w-4 h-4"></i>',
            },
        },
        drawCallback: function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        },
        dom: '<"flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4"lf>rt<"flex flex-col sm:flex-row items-center justify-between gap-3 mt-4"ip>',
    });
});
</script>
@endpush
