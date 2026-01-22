<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModulAplikasiModel;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    public function getRoles($moduleType)
    {
        // $user = Auth::user()->load(['roles' => function ($query) {
        //     // Filter agar role 'aksesaplikasi' tidak ikut diambil
        //     $query->where('name', '!=', 'aksesaplikasi');
        // }]);
        // $hrisMenus = $user->roles->map(function ($role) use ($moduleType) {
        // return [
        //         'title' => $role->title, // Contoh: "SDM Administrator"
        //         'sub'   => 'Paramadina',  // Contoh: "Pusat Kepegawaian"
        //         'url'   => $moduleType.'/'.$role->slug,     // Contoh: "/hris/admin"
        //     ];
        // })->toArray();
        // return response()->json($hrisMenus);

        $roles = auth()->user()->roles()
        ->whereHas('modules', function($q) use ($moduleType) {
            $q->where('url', $moduleType); 
        })
        ->with(['modules' => function($q) use ($moduleType) {
            // Eager load modul yang spesifik sedang diakses
            $q->where('url', $moduleType);
        }])
        ->get()
        ->map(function($role) use ($moduleType) {
            // Ambil modul pertama yang cocok dari hasil eager load
            $currentModule = $role->modules->first();
            
            return [
                'id'       => $role->id,
                'modul_id' => $currentModule->id ?? null, // Mengambil ID Modul
                'title'    => $role->title,
                'sub'      => 'Klik untuk menggunakan akses ini',
                'url'      => $currentModule->url ?? '#', // Langsung ambil dari objek modul
            ];
        });
        
        return response()->json($roles);

    }

    public function gate_module()
    {
        $data = [];
        $data['title'] = 'Gate Modul';
        
        // Ambil user yang login
        $user = auth()->user();

        // Jika Superadmin, mungkin Anda ingin menampilkan semua modul active
        if ($user->hasRole('superadmin')) {
            $data['modules'] = ModulAplikasiModel::where('status', 'active')
                ->orderBy('title', 'ASC')
                ->get();
        } else {
            // Ambil modul yang terhubung dengan role-role milik user
            $data['modules'] = ModulAplikasiModel::where('status', 'active')
                ->whereHas('roles', function($q) use ($user) {
                    $q->whereIn('newhris_roles.id', $user->roles->pluck('id'));
                })
                ->orderBy('title', 'ASC')
                ->get();
        }

        return view('gate_module', $data);
    }

    public function setActiveRole($role_id, $modul_id)
    {
        // 1. Cari role dan pastikan user memilikinya
        $role = auth()->user()->roles()->findOrFail($role_id);
        
        // 2. Cari modul untuk mendapatkan URL redirect
        $modul = \App\Models\ModulAplikasiModel::findOrFail($modul_id);

        // 3. Simpan ke Session
        session([
            'active_role_id'   => $role->id,
            'active_role_name' => $role->name,
            'active_modul_id'  => $modul->id,
            'active_modul_url' => $modul->url
        ]);

        // 4. Hapus cache sidebar agar menu di-load ulang sesuai role baru
        \Illuminate\Support\Facades\Cache::forget('sidebar_menus_role_' . $role->id);

        // 5. Redirect ke dashboard modul terkait
        return redirect($modul->url); 
    }
}
