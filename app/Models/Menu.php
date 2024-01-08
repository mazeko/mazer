<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = "menu";
    protected $fillable = [
        "menu_id", "menu_title", "menu_icon", "menu_link", "is_active"
    ];
}
