@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Reports</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">Coming Soon</h3>
            <p class="text-slate-500 text-sm">Laporan belum tersedia. Halaman ini dalam pengembangan.</p>
        </div>
    </div>
</div>
@endsection
