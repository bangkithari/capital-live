@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="max-w-3xl">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
            <a href="{{ route('customers.index') }}" class="hover:text-blue-600 transition-colors flex items-center">
                <i data-lucide="users" class="w-4 h-4 mr-1"></i> Customers
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-700 font-medium">Edit Customer</span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i data-lucide="pencil" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Edit Customer
                </h2>
                <p class="text-sm text-slate-400 mt-0.5">Update customer information</p>
            </div>

            <form action="{{ route('customers.update', $customer) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Customer Type -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Customer Type <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="individual" {{ old('type', $customer->type) === 'individual' ? 'checked' : '' }} class="peer sr-only" required>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-slate-300">
                                <div class="flex items-center">
                                    <i data-lucide="user" class="w-5 h-5 text-slate-400 mr-2"></i>
                                    <span class="text-sm font-semibold text-slate-700">Individual</span>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="business" {{ old('type', $customer->type) === 'business' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-slate-300">
                                <div class="flex items-center">
                                    <i data-lucide="building-2" class="w-5 h-5 text-slate-400 mr-2"></i>
                                    <span class="text-sm font-semibold text-slate-700">Business</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="individual-fields" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-1.5">First Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $customer->first_name) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label for="middle_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $customer->middle_name) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $customer->last_name) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                    </div>
                </div>

                <div id="business-field" style="display: none;">
                    <label for="business_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Business Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $customer->business_name) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center">
                        <i data-lucide="phone" class="w-4 h-4 mr-2 text-slate-400"></i> Contact Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label for="phone_cell" class="block text-sm font-semibold text-slate-700 mb-1.5">Cell Phone</label>
                            <input type="text" name="phone_cell" id="phone_cell" value="{{ old('phone_cell', $customer->phone_cell) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label for="phone_home" class="block text-sm font-semibold text-slate-700 mb-1.5">Home Phone</label>
                            <input type="text" name="phone_home" id="phone_home" value="{{ old('phone_home', $customer->phone_home) }}"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all resize-none">{{ old('notes', $customer->notes) }}</textarea>
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $customer->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20">
                        <span class="ml-2 text-sm font-medium text-slate-700">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('customers.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-violet-700 transition-all shadow-md shadow-blue-500/20 hover:shadow-lg">
                        <i data-lucide="save" class="w-4 h-4 mr-1.5 inline"></i> Update Customer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const isIndividual = this.value === 'individual';
                document.getElementById('individual-fields').style.display = isIndividual ? 'block' : 'none';
                document.getElementById('business-field').style.display = isIndividual ? 'none' : 'block';
            });
        });
        const checked = document.querySelector('input[name="type"]:checked');
        if (checked) checked.dispatchEvent(new Event('change'));
    </script>
    @endpush
@endsection
