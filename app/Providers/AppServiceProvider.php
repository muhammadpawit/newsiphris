<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Hris\Repositories\Module\ModulRepositoryInterface;
use Modules\Hris\Repositories\Module\ModulRepository;
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
    }
}