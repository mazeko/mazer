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
}