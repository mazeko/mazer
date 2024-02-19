<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Repositories\API\UserRepo;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userRepo;
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        try {
            $users = $this->userRepo->getAll();
            return response()->json(ResponseFormatter::success(200, __("Success"), $users), 200);
        } catch (\Exception $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function show(int $id)
    {
        try {
            $user = $this->userRepo->find($id);
            if(!$user){
                return response()->json(ResponseFormatter::failed(404, "User not found"), 404);
            }
            
            return response()->json(ResponseFormatter::success(200, __("Success"), $user), 200);
        } catch (\Exception $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function update()
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
