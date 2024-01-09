<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Repositories\API\SubmenuRepo;
use App\Http\Requests\API\SubmenuRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class SubmenuController extends Controller
{
    private $submenuRepo;
    public function __construct(SubmenuRepo $submenuRepo)
    {
        $this->submenuRepo = $submenuRepo;
    }

    public function index()
    {
        try {
            $submenus = $this->submenuRepo->findAll();

            return response()->json(ResponseFormatter::success(200, __("Success"), $submenus), 200);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function store(SubmenuRequest $request)
    {
        try {
            $lastID = $this->submenuRepo->lastID();
            $newID = Helper::generateID($lastID->submenu_id ?? "SM-000", 3);
            $data = [
                "submenu_id"   => $newID,
                "submenu_title"=> $request->submenu_title,
                "menu_id"      => $request->menu_id, 
                "submenu_icon" => $request->submenu_icon ?? null,
                "submenu_link" => $request->submenu_link ?? null,
                "is_active"  => $request->is_active ?? 1
            ];

            $this->submenuRepo->store($data);

            return response()->json(ResponseFormatter::success(201, __("Success"), $data), 201);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }

    public function update(SubmenuRequest $request, $id)
    {
        try {
            $submenu = $this->submenuRepo->find("id", $id);
            if(!$submenu){
                return response()->json(ResponseFormatter::failed(404, NOT_FOUND, __("Data not found")), 404);
            }
            $data = [
                "submenu_title"=> $request->submenu_title ?? $submenu->submenu_title,
                "menu_id"      => $request->menu_id ?? $submenu->menu_id, 
                "submenu_icon" => $request->submenu_icon ?? $submenu->submenu_icon,
                "submenu_link" => $request->submenu_link ?? $submenu->submenu_link,
                "is_active"  => $request->is_active ?? $submenu->is_active
            ];

            $this->submenuRepo->update($id, $data);

            return response()->json(ResponseFormatter::success(200, __("Success"), $data), 200);
        } catch (\Throwable $e) {
            return response()->json(ResponseFormatter::failed(400, ERROR, $e->getMessage()), 400);       
        }
    }
}
