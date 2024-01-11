<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $table = 'role_permissions';
    protected $fillable = [
        'menu_roleid','is_read','is_create','is_update','is_delete','is_export','is_verify','created_by','updated_by'
    ];
}
