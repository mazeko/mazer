<?php

namespace App\Repositories\API;

use App\Models\MenuRole;

class MenuRoleRepo {
    public function find($column, $value)
    {
        try {
            return MenuRole::where($column, $value)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }   
    }

    public function lastID()
    {
        try {
            return MenuRole::select("id","menu_roleid")->orderBy("id","desc")->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        } 
    }

    public function store($data = [])
    {
        try {
            return MenuRole::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function update($id, $data = [])
    {
        try {
            return MenuRole::where("menu_roleid", $id)->update($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function check($roleid, $menuid, $submenuid)
    {
        try {
            return MenuRole::where("role_id", $roleid)
                            ->where("menu_id", $menuid)
                            ->where("submenu_id", $submenuid)
                            ->first();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function findWIth($relation, $id)
    {
        try {
            return MenuRole::with($relation)->where("menu_roleid", $id)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }   
    }
}