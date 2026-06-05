@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
    <div class="max-w-4xl">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
            <a href="{{ route('customers.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i data-lucide="users" class="w-4 h-4 mr-1"></i> Customers
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-700 font-medium">Customer Details</span>
        </div>

        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-600 via-violet-600 to-purple-700 rounded-2xl p-6 mb-6 relative overflow-hidden shadow-xl shadow-blue-500/10">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white text-2xl font-bold border-2 border-white/30">
                    {{ strtoupper(substr($customer->type === 'business' ? $customer->business_name : $customer->first_name, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">
                        {{ $customer->type === 'business' ? $customer->business_name : trim($customer->first_name . ' ' . $customer->last_name) }}
                    </h1>
                    <p class="text-blue-100 text-sm flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold bg-white/20 rounded-full">
                            {{ ucfirst($customer->type) }}
                        </span>
                        {{ $customer->email ?? 'No email' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Contact Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-800 flex items-center mb-4">
                    <i data-lucide="phone" class="w-4 h-4 mr-2 text-blue-500"></i> Contact Information
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Email</span>
                        <span class="text-sm text-slate-600">{{ $customer->email ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Cell</span>
                        <span class="text-sm text-slate-600">{{ $customer->phone_cell ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Home</span>
                        <span class="text-sm text-slate-600">{{ $customer->phone_home ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Work</span>
                        <span class="text-sm text-slate-600">{{ $customer->phone_work ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-800 flex items-center mb-4">
                    <i data-lucide="info" class="w-4 h-4 mr-2 text-violet-500"></i> Customer Details
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Status</span>
                        @if($customer->is_active)
                            <span class="inline-flex items-center text-xs font-semibold text-emerald-600"><span class="w-2 h-2 bg-emerald-400 rounded-full mr-1.5"></span> Active</span>
                        @else
                            <span class="inline-flex items-center text-xs font-semibold text-rose-500"><span class="w-2 h-2 bg-rose-400 rounded-full mr-1.5"></span> Inactive</span>
                        @endif
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Created</span>
                        <span class="text-sm text-slate-600">{{ $customer->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Updated</span>
                        <span class="text-sm text-slate-600">{{ $customer->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($customer->notes)
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-800 flex items-center mb-3">
                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-amber-500"></i> Notes
                </h3>
                <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $customer->notes }}</p>
            </div>
        @endif

        <div class="mt-6 flex items-center space-x-3">
            <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20">
                <i data-lucide="pencil" class="w-4 h-4 mr-2"></i> Edit Customer
            </a>
            <a href="{{ route('customers.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                Back to List
            </a>
        </div>
    </div>
@endsection
