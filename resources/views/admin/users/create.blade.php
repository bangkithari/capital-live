@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i data-lucide="user-plus" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Create User
                </h2>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                @include('admin.users.partials.form', ['user' => null, 'roles' => $roles])

                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
