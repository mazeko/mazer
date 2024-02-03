<?php 

namespace App\Repositories\API;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;

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

    public function access($roleId)
    {
        try {
            $result = Menu::leftJoin('submenu as s', 'menu.menu_id', '=', 's.menu_id')
                    ->select('menu.menu_id','menu.menu_title','menu.menu_icon','menu.menu_link','s.submenu_id','s.submenu_title','s.submenu_link','s.submenu_icon')
                    ->whereIn('menu.menu_id', function ($query) use($roleId){
                        $query->select('menu_id')
                            ->distinct()
                            ->from('menu_role')
                            ->where('role_id', $roleId);
                    })
                    ->where(function ($query) use($roleId){
                        $query->whereNull('s.submenu_id')
                            ->orWhereExists(function ($subquery) use($roleId) {
                                $subquery->select(DB::raw(1))
                                    ->from('menu_role')
                                    ->where('role_id', $roleId)
                                    ->whereColumn('s.submenu_id', 'menu_role.submenu_id')
                                    ->whereColumn('menu.menu_id', 'menu_role.menu_id');
                            });
                    })->orderBy('menu.menu_id')->get();

            $data = collect($result)->groupBy('menu_id')->map(function ($items) {
                return [
                    'menu_id' => $items->first()['menu_id'],
                    'menu_title' => $items->first()['menu_title'],
                    'menu_icon' => $items->first()['menu_icon'],
                    'menu_link' => $items->first()['menu_link'],
                    'submenu' => $items->map(function ($item) {
                        return [
                            'submenu_id' => $item['submenu_id'],
                            'submenu_title' => $item['submenu_title'],
                            'submenu_link' => $item['submenu_link'],
                            'submenu_icon' => $item['submenu_icon'],
                        ];
                    })->filter(function ($item) {
                        return $item['submenu_id'] !== null;
                    })->values()->all(),
                ];
            })->values()->all();
            
            return $data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);   
        }
    }
}