<?php

namespace App\Repositories\API;

use App\Models\User;

class UserRepo {
    public function getActiveUser($column, $value)
    {
        try {
            return User::where($column, $value)->where("status", 1)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function getAll()
    {
        try {
            return User::select("id","name","username","role_id","email","status","created_at","updated_at")
                        ->with("user_login","user_role")
                        ->paginate(15);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function find(int $id)
    {
        try {
            return User::where("id", $id)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
}