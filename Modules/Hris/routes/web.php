<?php

use Illuminate\Support\Facades\Route;
use Modules\Hris\Http\Controllers\AdminController;
use Modules\Hris\Http\Controllers\DaftarModulController;
use Modules\Hris\Http\Controllers\MenuAksesController;
use Modules\Hris\Http\Controllers\PermissionController;
use Modules\Hris\Http\Controllers\RoleController;
use Modules\Hris\Http\Controllers\UserController;

// Middleware 'role' memastikan hanya admin yang bisa mengelola konfigurasi
// Tambahkan middleware kustom jika Anda ingin memaksa user lewat Gate Modul terlebih dahulu
Route::middleware(['auth', 'role:superadmin|superadminhris|adminhris'])
    ->name('hris.')
    ->prefix('hris')
    ->group(function() {

        // Dashboard HRIS
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Group Konfigurasi (Module, Role, User, Menu)
        Route::prefix('module')->group(function() {
            
            // 1. Group Daftar Module
            Route::name('daftar-module.')->prefix('daftar-module')->group(function() {
                Route::get('/', [DaftarModulController::class, 'index'])->name('index');
                Route::get('export-excel', [DaftarModulController::class, 'exportExcel'])->name('excel');
                Route::get('export-pdf', [DaftarModulController::class, 'exportPdf'])->name('pdf');
                Route::get('create', [DaftarModulController::class, 'create'])->name('create');
                Route::post('store', [DaftarModulController::class, 'store'])->name('store');
                Route::get('show/{id}', [DaftarModulController::class, 'show'])->name('show');
                Route::get('{id}/edit', [DaftarModulController::class, 'edit'])->name('edit');
                Route::put('{id}', [DaftarModulController::class, 'update'])->name('update');
                Route::delete('{id}', [DaftarModulController::class, 'destroy'])->name('destroy');
            });

            // 2. Group Role (PENTING: Pastikan Controller ini yang mengelola Poin 2 - Assign Modul ke Role)
            Route::name('daftar-role.')->prefix('daftar-role')->group(function() {
                Route::get('/', [RoleController::class, 'index'])->name('index');
                Route::get('export-excel', [RoleController::class, 'exportExcel'])->name('excel');
                Route::get('export-pdf', [RoleController::class, 'exportPdf'])->name('pdf');
                Route::get('create', [RoleController::class, 'create'])->name('create');
                Route::post('store', [RoleController::class, 'store'])->name('store');
                Route::get('show/{id}', [RoleController::class, 'show'])->name('show');
                Route::get('{id}/edit', [RoleController::class, 'edit'])->name('edit');
                Route::put('{id}', [RoleController::class, 'update'])->name('update');
                Route::delete('{id}', [RoleController::class, 'destroy'])->name('destroy');
            });

            // 3. Group Menu (PENTING: Controller ini yang mengelola Poin 3 - Assign Menu ke Role)
            Route::name('daftar-menu.')->prefix('daftar-menu')->group(function() {
                Route::get('/', [MenuAksesController::class, 'index'])->name('index');
                Route::get('export-excel', [MenuAksesController::class, 'exportExcel'])->name('excel');
                Route::get('export-pdf', [MenuAksesController::class, 'exportPdf'])->name('pdf');
                Route::get('create', [MenuAksesController::class, 'create'])->name('create');
                Route::post('store', [MenuAksesController::class, 'store'])->name('store');
                Route::get('show/{id}', [MenuAksesController::class, 'show'])->name('show');
                Route::get('{id}/edit', [MenuAksesController::class, 'edit'])->name('edit');
                Route::put('{id}', [MenuAksesController::class, 'update'])->name('update');
                Route::delete('{id}', [MenuAksesController::class, 'destroy'])->name('destroy');
            });

            // 4. Group User (Assign Role ke User)
            Route::name('daftar-user.')->prefix('daftar-user')->group(function() {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('export-excel', [UserController::class, 'exportExcel'])->name('excel');
                Route::get('export-pdf', [UserController::class, 'exportPdf'])->name('pdf');
                Route::get('create', [UserController::class, 'create'])->name('create');
                Route::post('store', [UserController::class, 'store'])->name('store');
                Route::get('show/{id}', [UserController::class, 'show'])->name('show');
                Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('{id}', [UserController::class, 'update'])->name('update');
                Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
            });

            // 5. Group Permission
            Route::name('daftar-permission.')->prefix('daftar-permission')->group(function() {
                Route::get('/', [PermissionController::class, 'index'])->name('index');
                Route::get('export-excel', [PermissionController::class, 'exportExcel'])->name('excel');
                Route::get('export-pdf', [PermissionController::class, 'exportPdf'])->name('pdf');
                Route::post('store', [PermissionController::class, 'store'])->name('store');
                Route::get('show/{id}', [PermissionController::class, 'show'])->name('show');
                Route::put('{id}', [PermissionController::class, 'update'])->name('update');
                Route::delete('{id}', [PermissionController::class, 'destroy'])->name('destroy');
            });
        });
    });