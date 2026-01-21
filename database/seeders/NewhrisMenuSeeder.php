<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewhrisMenu;

class NewhrisMenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Menu Title
        NewhrisMenu::create([
            'title' => 'Menu',
            'key' => 't-menu',
            'is_title' => true,
            'order' => 1
        ]);

        // 2. Dashboard (Single Menu)
        NewhrisMenu::create([
            'title' => 'Dashboards',
            'icon' => 'ri-dashboard-2-line',
            'url' => '/hris',
            'slug' => 'hris',
            'order' => 2
        ]);

        // 3. Master Data (Dropdown)
        $master = NewhrisMenu::create([
            'title' => 'Master Data',
            'icon' => 'ri-stack-line',
            'target_id' => 'sidebarMasterData',
            'slug' => 'master',
            'order' => 3
        ]);

        $master->children()->createMany([
            ['title' => 'Master Rektorat', 'url' => '/master/rektorat', 'slug' => 'master/rektorat', 'order' => 1],
            ['title' => 'Master Direktorat', 'url' => '/master/direktorat', 'slug' => 'master/direktorat', 'order' => 2],
            ['title' => 'Master Bagian', 'url' => '/master/bagian', 'slug' => 'master/bagian', 'order' => 3],
            ['title' => 'Master Jabatan Struktural', 'url' => '/master/jabatan-struktural', 'slug' => 'master/jabatan-struktural', 'order' => 4],
        ]);

        // 4. Manajemen Pegawai (Dropdown dengan Sub-dropdown)
        $pegawai = NewhrisMenu::create([
            'title' => 'Manajemen Pegawai',
            'icon' => 'ri-pages-line',
            'target_id' => 'sidebarManajemenKepegawaians',
            'slug' => 'pegawai',
            'order' => 4
        ]);

        $pegawai->children()->create([
            'title' => 'Daftar Pegawai',
            'url' => '/pegawai/daftar',
            'slug' => 'pegawai/daftar',
            'order' => 1
        ]);

        // Sub-dropdown Dokumen
        $dokumen = $pegawai->children()->create([
            'title' => 'Dokumen',
            'target_id' => 'sidebarDokumen',
            'slug' => 'pegawai/dokumen',
            'order' => 2
        ]);

        $dokumen->children()->createMany([
            ['title' => 'Surat Tugas', 'url' => '/pegawai/dokumen/surat-tugas', 'slug' => 'pegawai/dokumen/surat-tugas', 'order' => 1],
            ['title' => 'Kontrak Pengajar', 'url' => '/pegawai/dokumen/kontrak', 'slug' => 'pegawai/dokumen/kontrak', 'order' => 2],
        ]);

        // 5. Manajemen Presensi
        $presensi = NewhrisMenu::create([
            'title' => 'Manajemen Presensi',
            'icon' => 'ri-timer-line',
            'target_id' => 'sidebarManajemenPresensi',
            'slug' => 'presensi',
            'order' => 5
        ]);

        $presensi->children()->createMany([
            ['title' => 'Master Shift', 'url' => '/presensi/shift', 'slug' => 'presensi/shift', 'order' => 1],
            ['title' => 'Laporan Presensi', 'url' => '/presensi/laporan', 'slug' => 'presensi/laporan', 'order' => 2],
        ]);

        // 6. Manajemen Aplikasi
        $aplikasi = NewhrisMenu::create([
            'title' => 'Manajemen Aplikasi',
            'icon' => 'ri-settings-line',
            'target_id' => 'sidebarManajemenAplikasi',
            'slug' => 'hris/modul',
            'order' => 6
        ]);

        $aplikasi->children()->createMany([
            ['title' => 'Daftar Module', 'url' => '/hris/module/daftar-module', 'slug' => 'hris/daftar-module', 'order' => 1],
            ['title' => 'Daftar Role', 'url' => '/hris/module/daftar-role', 'slug' => 'hris/daftar-role', 'order' => 2],
            ['title' => 'Daftar Permission', 'url' => '/hris/module/daftar-permission', 'slug' => 'hris/daftar-permission', 'order' => 3],
            ['title' => 'Daftar User', 'url' => '/hris/module/daftar-user', 'slug' => 'hris/daftar-user', 'order' => 4],
        ]);
    }
}