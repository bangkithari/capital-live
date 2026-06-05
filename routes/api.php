<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CifApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\HealthApiController;
use App\Http\Controllers\Api\MenuApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| CpitalLive API v1
| All routes are prefixed with /api
| Protected routes require Bearer token (auth:sanctum or auth:api middleware)
*/

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/health', HealthApiController::class)->name('api.health');
    Route::post('/auth/login', [AuthApiController::class, 'login'])
        ->name('api.auth.login');

    // Protected routes (JWT auth)
    Route::middleware('auth:api')->group(function () {
        // Authentication
        Route::get('/auth/me', [AuthApiController::class, 'me'])
            ->name('api.auth.me');
        Route::post('/auth/refresh', [AuthApiController::class, 'refresh'])
            ->name('api.auth.refresh');
        Route::post('/auth/logout', [AuthApiController::class, 'logout'])
            ->name('api.auth.logout');

        // Dashboard
        Route::get('/dashboard', [DashboardApiController::class, 'index'])
            ->name('api.dashboard');

        // CIF
        Route::apiResource('cif', CifApiController::class)
            ->only(['index', 'show'])
            ->names('api.cif');

        // Menus
        Route::get('/menus', [MenuApiController::class, 'index'])
            ->name('api.menus.index');
        Route::get('/menus/tree', [MenuApiController::class, 'tree'])
            ->name('api.menus.tree');
    });
});
