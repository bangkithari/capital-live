<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CpitalLive') }} - Sign In</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        </style>
    </head>
    <body class="h-full font-sans text-slate-900 antialiased">
        <div class="min-h-full flex">
            <!-- Left: Decorative Panel (desktop only) -->
            <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative bg-gradient-to-br from-blue-600 via-violet-600 to-purple-800 p-12 flex-col justify-between overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4"></div>
                <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>

                <div class="relative z-10">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-xl">CL</span>
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">CpitalLive</span>
                    </div>
                </div>

                <div class="relative z-10 max-w-lg">
                    <h1 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">
                        Manage your insurance business
                        <span class="text-blue-200">smarter</span>
                    </h1>
                    <p class="text-lg text-blue-100/80 leading-relaxed">
                        CpitalLive Individual gives you everything you need to manage customers, policies, agents, and appointments — all in one powerful platform.
                    </p>

                    <!-- Feature pills -->
                    <div class="flex flex-wrap gap-3 mt-8">
                        <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm text-white/90 border border-white/10">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></span> Customer CRM
                        </span>
                        <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm text-white/90 border border-white/10">
                            <span class="w-2 h-2 bg-blue-300 rounded-full mr-2"></span> Policy Tracking
                        </span>
                        <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm text-white/90 border border-white/10">
                            <span class="w-2 h-2 bg-violet-300 rounded-full mr-2"></span> Agent Portal
                        </span>
                        <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm text-white/90 border border-white/10">
                            <span class="w-2 h-2 bg-amber-300 rounded-full mr-2"></span> Scheduling
                        </span>
                    </div>
                </div>

                <div class="relative z-10">
                    <p class="text-sm text-blue-200/60">&copy; {{ date('Y') }} CpitalLive Individual. Built for insurance professionals.</p>
                </div>
            </div>

            <!-- Right: Auth Form -->
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-slate-50">
                <!-- Mobile logo -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25 mx-auto mb-3">
                        <span class="text-white font-bold text-xl">CL</span>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">CpitalLive</span>
                </div>

                <div class="w-full sm:max-w-md">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                        {{ $slot }}
                    </div>

                    <p class="text-center text-xs text-slate-400 mt-6">
                        Protected by enterprise-grade security
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
