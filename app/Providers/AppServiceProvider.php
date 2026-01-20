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

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Staff
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);

        // Bind Modul Aplikasi
        $this->app->bind(ModulRepositoryInterface::class, ModulRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }
}