<?php 

namespace App\Repositories\API;

use App\Models\Submenu;

class SubmenuRepo {
    public function find($column, $value)
    {
        try {
            return Submenu::where($column, $value)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }   
    }

    public function findAll()
    {
        try {
            return Submenu::orderBy("id","desc")->paginate(10);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }   
    }

    public function lastID()
    {
        try {
            return Submenu::select("id","submenu_id")->orderBy("id","desc")->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        } 
    }

    public function store($data = [])
    {
        try {
            return Submenu::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }

    public function update($id, $data = [])
    {
        try {
            return Submenu::where("id", $id)->update($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
}