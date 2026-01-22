<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $table = 'newhris_roles';

    protected $fillable = [
        'name',
        'guard_name',
        'title',
        'deskripsi',
        'slug',
        'created_at',
        'updated_at',  
    ];

    public function modules()
    {
        // Parameter: ModelTarget, NamaTabelPivot, FK_di_pivot_untuk_Role, FK_di_pivot_untuk_Modul
        return $this->belongsToMany(ModulAplikasiModel::class, 'modul_role', 'role_id', 'modul_id');
    }
}