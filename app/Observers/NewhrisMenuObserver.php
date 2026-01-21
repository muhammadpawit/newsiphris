<?php

namespace App\Observers;

use App\Models\NewhrisMenu;
use Illuminate\Support\Facades\Cache;

class NewhrisMenuObserver
{
    private function clearCache()
    {
        /** * Karena kita menggunakan key dinamis 'sidebar_menus_role_{ids}', 
         * kita tidak bisa menghapus satu per satu secara spesifik dengan mudah.
         * Solusi paling aman adalah flush cache atau menggunakan tags jika driver mendukung.
         */
        
        // Jika Anda menggunakan driver 'file' atau 'database':
        Cache::flush(); 

        // Jika Anda menggunakan driver 'redis' atau 'memcached', Anda bisa menggunakan tags 
        // saat menyimpan di ViewServiceProvider agar bisa dihapus secara spesifik:
        // Cache::tags(['sidebar'])->flush();
    }

    public function created(NewhrisMenu $menu) { $this->clearCache(); }
    public function updated(NewhrisMenu $menu) { $this->clearCache(); }
    public function deleted(NewhrisMenu $menu) { $this->clearCache(); }
    
    /**
     * Tambahkan juga untuk event relasi jika ada perubahan pada pivot menu_role
     * Jika Anda menggunakan sync(), ini mungkin perlu dipicu manual dari Controller
     */
}