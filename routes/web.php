<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleAccessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CifController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CIF
    Route::get('/cif/list', [CifController::class, 'list'])->name('cif.list');
    Route::get('/cif', [CifController::class, 'index'])->name('cif.index');
    Route::get('/cif/{cif}', [CifController::class, 'show'])->name('cif.show');

    // Admin Menu Management
    Route::prefix('admin/menus')->name('admin.menus.')->middleware('admin')->group(function () {
        Route::post('/reorder', [MenuController::class, 'reorder'])->name('reorder');
        Route::post('/{menu}/toggle', [MenuController::class, 'toggle'])->name('toggle');
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
    });

    Route::resource('admin/users', UserController::class)
        ->middleware('admin')
        ->names('admin.users')
        ->except(['show']);

    Route::get('/admin/role-access', [RoleAccessController::class, 'index'])
        ->middleware('admin')
        ->name('admin.role-access.index');
    Route::put('/admin/role-access', [RoleAccessController::class, 'update'])
        ->middleware('admin')
        ->name('admin.role-access.update');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
