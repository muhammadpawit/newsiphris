<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ModulAplikasiModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();    
            
            if ($user) {
                Auth::login($user);
                
                // Simpan avatar google ke session dengan key 'google_avatar'
                session(['google_avatar' => $googleUser->avatar]);

                return to_route('gate');
            }
            return redirect('login')->withErrors(['msg' => 'Login gagal']);
            
        } catch (\Exception $e) {
            return redirect('login')->withErrors(['msg' => 'Failed to login with Google']);
        }
    }

    public function getRoles($moduleType)
    {
        // Logika pengambilan data (contoh hardcoded, bisa diganti query DB)
        $data = [
            'akademik' => [
                ['title' => 'Admin Keuangan Akademik', 'sub' => 'Paramadina', 'url' => '/akademik/finance'],
                ['title' => 'Admin Akademik', 'sub' => 'Paramadina', 'url' => '/akademik/admin'],
                ['title' => 'Dosen', 'sub' => 'Paramadina', 'url' => '/akademik/dosen'],
            ],
            'hris' => [
                ['title' => 'SDM Administrator', 'sub' => 'Pusat Kepegawaian', 'url' => 'hris'],
                ['title' => 'Pegawai Umum', 'sub' => 'Paramadina', 'url' => '/hris/dashboard'],
            ],
        ];

        $roles = $data[$moduleType] ?? [];

        return response()->json($roles);
    }

    function gate_module()
    {
        $data=[];
        $data['title']='Gate Modul ';
        $data['modules']=ModulAplikasiModel::where('status','active')->orderBy('title','ASC')->get();
        return view('gate_module', $data);
    }
}