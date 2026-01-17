<?php

use Illuminate\Support\Facades\Route;
use Modules\Hris\Http\Controllers\HrisController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('hris', HrisController::class)->names('hris');
});
