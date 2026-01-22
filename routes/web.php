<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GateController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route yang kamu panggil di tombol Blade tadi
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');

// Route callback untuk menerima data dari Google
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth','role:aksesaplikasi'])
    ->group(function () {
        Route::get('gate-module', [GateController::class, 'gate_module'])->name('gate');
        Route::get('/roles/{moduleType}', [GateController::class, 'getRoles'])->name('roles');
        // Route untuk set session
        Route::get('/set-active-role/{role_id}/{modul_id}', [GateController::class, 'setActiveRole'])->name('set-role');
});

