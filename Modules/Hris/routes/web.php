<?php

use Illuminate\Support\Facades\Route;
use Modules\Hris\Http\Controllers\AdminController;

Route::middleware(['auth','role:superadmin|superadminhris|adminhris'])->name('hris.')->prefix('hris')->group(function() {
    Route::get('/admin',[AdminController::class, 'index'])->name('index');
});