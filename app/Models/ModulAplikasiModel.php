<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulAplikasiModel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'modul_aplikasi';
    protected $fillable = [
        'title',
        'deskripsi',
        'color',
        'status',
        'icon',
        'url',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'modul_role', 'modul_id', 'role_id');
    }
}
