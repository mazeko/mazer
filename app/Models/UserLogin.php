<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;
    protected $table = 'user_login';
    protected $fillable = [
        'email', 'attempts', 'blocked_until', 'ip_address', 'last_login'
    ];
}
