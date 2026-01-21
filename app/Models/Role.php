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
}