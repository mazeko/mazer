<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;
    protected $table = 'submenu';
    protected $fillable = [
        'submenu_id','submenu_title','menu_id','submenu_link','submenu_icon','is_active'
    ];
}
