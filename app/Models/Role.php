<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Model ini akan otomatis menggunakan tabel 'newhris_roles' 
    // karena sudah kita atur di config/permission.php
}