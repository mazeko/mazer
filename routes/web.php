<?php

use App\Http\Controllers\WEB\DashboardController;
use App\Http\Controllers\WEB\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get("/", function(){
    return view("auth/login");
});

Route::prefix("main")->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get("dashboard","index");
    });

    Route::controller(UserController::class)->group(function(){
        Route::get("users","index");
    });
});

Route::get("/error", function(){
    return view("errors/404");
});