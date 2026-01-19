<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $repoPath = base_path('Modules/Hris/app/Repositories');
    $namespace = 'Modules\\Hris\\Repositories';

    if (is_dir($repoPath)) {
        // Ambil semua file .php di folder tersebut
        $files = glob($repoPath . '/*.php');

        foreach ($files as $file) {
            // Gunakan PATHINFO_FILENAME (tanpa underscore di tengah)
            $filename = pathinfo($file, PATHINFO_FILENAME);

            // Kita hanya memproses file yang berakhiran 'Interface'
            if (str_ends_with($filename, 'Interface')) {
                $interfaceFullClass = $namespace . '\\' . $filename;
                
                // Cari nama class implementasinya (hapus kata 'Interface')
                $className = str_replace('Interface', '', $filename);
                $implementationFullClass = $namespace . '\\' . $className;

                // Cek apakah Class implementasinya ada
                if (class_exists($implementationFullClass)) {
                    $this->app->bind($interfaceFullClass, $implementationFullClass);
                }
            }
        }
    }
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
