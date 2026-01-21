<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Hris\Repositories\Module\ModulRepositoryInterface;
use Modules\Hris\Repositories\Module\ModulRepository;
use Modules\Hris\Repositories\Permission\PermissionRepository;
use Modules\Hris\Repositories\Permission\PermissionRepositoryInterface;
use Modules\Hris\Repositories\Role\RoleRepository;
use Modules\Hris\Repositories\Role\RoleRepositoryInterface;
use Modules\Hris\Repositories\Staff\StaffRepositoryInterface;
use Modules\Hris\Repositories\Staff\StaffRepository;
use Modules\Hris\Repositories\User\UserRepository;
use Modules\Hris\Repositories\User\UserRepositoryInterface;
use App\Models\NewhrisMenu;
use App\Observers\NewhrisMenuObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Staff
        NewhrisMenu::observe(NewhrisMenuObserver::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);

        // Bind Modul Aplikasi
        $this->app->bind(ModulRepositoryInterface::class, ModulRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(
            \Modules\Hris\Repositories\Menu\MenuRepositoryInterface::class,
            \Modules\Hris\Repositories\Menu\MenuRepository::class
        );
    }
}