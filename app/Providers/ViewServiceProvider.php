<?php

namespace App\Providers;

use App\Models\NewhrisMenu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    

public function boot(): void
{
    View::composer('layouts.partials.sidebar', function ($view) {
        if (Auth::check() && session()->has('active_role_id')) {
            
            $user = Auth::user();
            $activeRoleId = session('active_role_id'); 
            
            // KUNCI: Key cache harus menyertakan ID role aktif
            $cacheKey = 'sidebar_menus_role_' . $activeRoleId;

            // Debug sementara: Uncomment baris di bawah ini untuk mematikan cache saat testing
            // Cache::forget($cacheKey); 

            $menus = Cache::rememberForever($cacheKey, function () use ($user, $activeRoleId) {
                
                $isSuperAdmin = $user->hasRole('superadmin');

                // 1. Query Dasar
                $query = NewhrisMenu::with(['children' => function ($q) use ($activeRoleId, $isSuperAdmin) {
                    if (!$isSuperAdmin) {
                        $q->whereHas('roles', function ($rq) use ($activeRoleId) {
                            // Gunakan ID yang spesifik dari session
                            $rq->where('id', $activeRoleId); 
                        });
                    }
                    $q->orderBy('order', 'asc');
                }, 'children.children'])
                ->whereNull('parent_id');

                // 2. Filter Menu Utama (Level 0)
                if (!$isSuperAdmin) {
                    $query->whereHas('roles', function ($q) use ($activeRoleId) {
                        $q->where('id', $activeRoleId);
                    });
                }

                return $query->orderBy('order', 'asc')->get();
            });

            $view->with('menus', $menus);
        }
    });
}
}