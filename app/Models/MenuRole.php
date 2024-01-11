<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    use HasFactory;
    protected $table = 'menu_role';
    protected $fillable = [
        'menu_roleid','role_id','menu_id','submenu_id','created_by','updated_by'
    ];

    public function permissions(){
        return $this->hasMany(RolePermission::class, "menu_roleid", "menu_roleid");
    }
}
