<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModulAplikasiModel;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    public function getRoles($moduleType)
    {
        $user = Auth::user()->load(['roles' => function ($query) {
            // Filter agar role 'aksesaplikasi' tidak ikut diambil
            $query->where('name', '!=', 'aksesaplikasi');
        }]);
        $hrisMenus = $user->roles->map(function ($role) use ($moduleType) {
        return [
                'title' => $role->title, // Contoh: "SDM Administrator"
                'sub'   => 'Paramadina',  // Contoh: "Pusat Kepegawaian"
                'url'   => $moduleType,     // Contoh: "/hris/admin"
            ];
        })->toArray();
        return response()->json($hrisMenus);
    }

    function gate_module()
    {
        $data=[];
        $data['title']='Gate Modul ';
        $data['modules']=ModulAplikasiModel::where('status','active')->orderBy('title','ASC')->get();
        return view('gate_module', $data);
    }
}
