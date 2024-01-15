<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Repositories\API\MenuRepo;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\MenuRequest;

class MenuControler extends Controller
{
    private $menuRepo;
    public function __construct(MenuRepo $menuRepo)
    {
        $this->menuRepo = $menuRepo;
    }

    public function store(MenuRequest $request)
    {
        try {
            $lastID = $this->menuRepo->lastID();
            $newID = Helper::generateID($lastID->menu_id ?? "M-00", 2);
            $data = [
                "menu_id"   => $newID,
                "menu_title" => $request->title,
                "menu_icon"  => $request->menu_icon ?? null,
                "menu_link"  => $request->menu_link ?? null,
                "is_active"  => $request->is_active ?? 1
            ];

            $this->menuRepo->store($data);

            return response()->json(ResponseFormatter::success(201, __("Success"), $data), 201);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function update(MenuRequest $request, $id)
    {
        try {
            $menu = $this->menuRepo->find("id", $id);
            if(!$menu){
                return response()->json(ResponseFormatter::failed(404, NOT_FOUND, __("Data not found")), 404);
            }

            $data = [
                "menu_title" => $request->title ?? $menu->title,
                "menu_icon"  => $request->menu_icon ?? $menu->menu_icon,
                "menu_link"  => $request->menu_link ?? $menu->menu_link,
                "is_active"  => $request->is_active ?? $menu->is_active
            ];

            $this->menuRepo->update($id, $data);

            return response()->json(ResponseFormatter::success(201, __("Success"), $data), 201);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function access(Request $request)
    {
        try {
            $user = JWTAuth::getPayload($request->bearerToken())->toArray();
            $access = $this->menuRepo->access($user["role_id"]);
            if(!$access){
                return response()->json(ResponseFormatter::failed(404, NOT_FOUND, __("Data not found")), 404);
            }

            return response()->json(ResponseFormatter::success(200, __("Success"), $access), 200);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed($e->getCode(), ERROR, $e->getMessage()),  500);       
        }
    }
}
