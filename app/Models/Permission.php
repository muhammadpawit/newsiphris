<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // Model ini akan otomatis menggunakan tabel 'newhris_permissions'
    protected $table = 'newhris_permissions';
}