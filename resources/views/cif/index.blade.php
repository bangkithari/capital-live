@extends('layouts.app')

@section('title', 'CIF')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">CIF</h1>
            <p class="text-sm text-slate-500 mt-1">Customer information records from the current database schema.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="cifTable" class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">CIF ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID Number</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('#cifTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("cif.list") }}',
        pageLength: 10,
        order: [[6, 'desc']],
        columnDefs: [
            { targets: -1, orderable: false, searchable: false }
        ],
        language: {
            processing: '<div class="flex items-center justify-center py-8"><span class="text-sm text-slate-500 font-medium">Loading CIF records...</span></div>',
            search: '',
            searchPlaceholder: 'Search CIF...',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ CIF records',
            infoEmpty: 'No CIF records',
            zeroRecords: 'No matching CIF records found'
        }
    });
});
</script>
@endpush
