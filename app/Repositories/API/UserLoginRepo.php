<?php 

namespace App\Repositories\API;

use App\Models\UserLogin;

class UserLoginRepo {
    public function store($data = [])
    {
        try {
            return UserLogin::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function find($email)
    {
        try {
            return UserLogin::where("email", $email)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
}