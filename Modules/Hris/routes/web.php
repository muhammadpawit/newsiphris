<?php

use Illuminate\Support\Facades\Route;
use Modules\Hris\Http\Controllers\AdminController;
use Modules\Hris\Http\Controllers\DaftarModulController;
use Modules\Hris\Http\Controllers\PermissionController;
use Modules\Hris\Http\Controllers\RoleController;

Route::middleware(['auth','role:superadmin|superadminhris|adminhris'])->name('hris.')->prefix('hris')->group(function() {
    Route::get('/',[AdminController::class, 'index'])->name('index');
    Route::middleware(['auth'])->prefix('module')->group(function() {
        // Group Daftar Module
        Route::name('daftar-module.')->prefix('daftar-module')->group(function() {
            Route::get('/', [DaftarModulController::class, 'index'])->name('index');
            Route::get('export-excel', [DaftarModulController::class, 'exportExcel'])->name('excel');
            Route::get('export-pdf', [DaftarModulController::class, 'exportPdf'])->name('pdf');
            Route::get('create', [DaftarModulController::class, 'create'])->name('create');
            Route::post('store', [DaftarModulController::class, 'store'])->name('store');
            
            // Route dengan parameter diletakkan di bawah
            Route::get('show/{id}', [DaftarModulController::class, 'show'])->name('show');
            Route::get('{id}/edit', [DaftarModulController::class, 'edit'])->name('edit');
            Route::put('{id}', [DaftarModulController::class, 'update'])->name('update');
            Route::delete('{id}', [DaftarModulController::class, 'destroy'])->name('destroy');
        });

        // Group Role
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

        // Group Permission
        Route::name('daftar-permission.')->prefix('daftar-permission')->group(function() {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('export-excel', [PermissionController::class, 'exportExcel'])->name('excel');
            Route::get('export-pdf', [PermissionController::class, 'exportPdf'])->name('pdf');
            Route::get('create', [PermissionController::class, 'create'])->name('create');
            Route::post('store', [PermissionController::class, 'store'])->name('store');

            Route::get('show/{id}', [PermissionController::class, 'show'])->name('show');
            Route::get('{id}/edit', [PermissionController::class, 'edit'])->name('edit');
            Route::put('{id}', [PermissionController::class, 'update'])->name('update');
            Route::delete('{id}', [PermissionController::class, 'destroy'])->name('destroy');
        });


    });
});