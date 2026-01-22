<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewhrisMenu extends Model
{
    protected $table = 'newhris_menus';
    protected $fillable = ['parent_id', 'title', 'key', 'icon', 'url', 'slug', 'target_id', 'order', 'is_title'];

    // Relasi untuk mengambil sub-menu (anak)
    public function children()
    {
        return $this->hasMany(NewhrisMenu::class, 'parent_id', 'id')->orderBy('order', 'asc');
    }

    // Relasi ke induk (opsional)
    public function parent()
    {
        return $this->belongsTo(NewhrisMenu::class, 'parent_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'newhris_menu_role', 'menu_id', 'role_id');
    }
}