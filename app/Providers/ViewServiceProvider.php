<?php

namespace App\Providers;

use App\Models\NewhrisMenu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.partials.sidebar', function ($view) {
            // Pastikan user sudah login
            if (Auth::check()) {
                $user = Auth::user();
                $roleIds = $user->roles->pluck('id')->sort()->implode('-');
                
                // Nama cache dibuat unik per kombinasi role user
                // Contoh: sidebar_menus_role_1-2 (untuk user dengan role ID 1 dan 2)
                $cacheKey = 'sidebar_menus_role_' . ($roleIds ?: 'guest');

                $menus = Cache::rememberForever($cacheKey, function () use ($user) {
                    $query = NewhrisMenu::with(['children' => function ($q) use ($user) {
                        // Filter sub-menu berdasarkan role (kecuali superadmin)
                        if (!$user->hasRole('superadmin')) {
                            $q->whereHas('roles', function ($rq) use ($user) {
                                $rq->whereIn('roles.id', $user->roles->pluck('id'));
                            });
                        }
                        $q->orderBy('order', 'asc');
                    }, 'children.children']) // Eager load sampai cucu menu
                    ->whereNull('parent_id')
                    ->orderBy('order', 'asc');

                    // Filter menu utama berdasarkan role (kecuali superadmin)
                    if (!$user->hasRole('superadmin')) {
                        $query->whereHas('roles', function ($q) use ($user) {
                            $q->whereIn('roles.id', $user->roles->pluck('id'));
                        });
                    }

                    return $query->get();
                });

                $view->with('menus', $menus);
            }
        });
    }
}