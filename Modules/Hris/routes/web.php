<?php

use Illuminate\Support\Facades\Route;
use Modules\Hris\Http\Controllers\AdminController;
use Modules\Hris\Http\Controllers\DaftarModulController;

Route::middleware(['auth','role:superadmin|superadminhris|adminhris'])->name('hris.')->prefix('hris')->group(function() {
    Route::get('/',[AdminController::class, 'index'])->name('index');

    Route::middleware(['auth'])->name('daftar-module.')->prefix('module')->group(function() {
        // 1. Letakkan Route Statis (tanpa {id}) di paling atas
        Route::get('daftar-module', [DaftarModulController::class, 'index'])->name('index');
        Route::get('daftar-module/export-excel', [DaftarModulController::class, 'exportExcel'])->name('excel');
        Route::get('daftar-module/export-pdf', [DaftarModulController::class, 'exportPdf'])->name('pdf');
        Route::get('daftar-module-create', [DaftarModulController::class, 'create'])->name('create');
        Route::post('daftar-module-store', [DaftarModulController::class, 'store'])->name('store');

        // 2. Letakkan Route dengan Parameter {id} di bawah
        Route::get('daftar-module-show/{id}', [DaftarModulController::class, 'show'])->name('show');
        Route::get('daftar-module/{id}', [DaftarModulController::class, 'edit'])->name('edit'); // Ini yang sebelumnya "memakan" route excel
        Route::put('daftar-module/{id}', [DaftarModulController::class, 'update'])->name('update');
        Route::delete('daftar-module-destroy/{id}', [DaftarModulController::class, 'destroy'])->name('destroy');
    });
});