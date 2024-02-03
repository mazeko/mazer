<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $title = "Dashboard";
            return view('pages/dashboard', compact("title"));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
