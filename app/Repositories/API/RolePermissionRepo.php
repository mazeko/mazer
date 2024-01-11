<?php

namespace App\Repositories\API;

use App\Models\RolePermission;

class RolePermissionRepo {
    public function store($data = [])
    {
        try {
            return RolePermission::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function update($id, $data = [])
    {
        try {
            return RolePermission::where("menu_roleid", $id)->update($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
}