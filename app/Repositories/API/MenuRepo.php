<?php 

namespace App\Repositories\API;

use App\Models\Menu;

class MenuRepo {
    public function find($column, $value)
    {
        try {
            return Menu::where($column, $value)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }   
    }

    public function lastID()
    {
        try {
            return Menu::select("id","menu_id")->orderBy("id","desc")->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        } 
    }

    public function store($data = [])
    {
        try {
            return Menu::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
    
    public function update($id, $data = [])
    {
        try {
            return Menu::where("id", $id)->update($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
}