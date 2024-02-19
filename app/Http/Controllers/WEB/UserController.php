<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        try {
            return view("pages/users");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
