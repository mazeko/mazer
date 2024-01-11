<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Repositories\API\MenuRoleRepo;
use App\Http\Requests\API\MenuRoleRequest;
use App\Repositories\API\RolePermissionRepo;

class MenuRoleController extends Controller
{
    private $menuRoleRepo;
    private $rolePermissionRepo;
    public function __construct(MenuRoleRepo $menuRoleRepo, RolePermissionRepo $rolePermissionRepo)
    {
        $this->menuRoleRepo = $menuRoleRepo;
        $this->rolePermissionRepo = $rolePermissionRepo;
    }

    public function store(MenuRoleRequest $request)
    {
        try {
            $user   = JWTAuth::getPayload($request->bearerToken())->toArray();
            $check = $this->menuRoleRepo->check($user["role_id"], $request->menu_id, $request->submenu_id);
            if($check){
                return response()->json(ResponseFormatter::failed(400, __("Permission already exists"), BAD_REQUEST), 400);
            }

            $lastID = $this->menuRoleRepo->lastID();
            $newID  = Helper::generateID($lastID->menu_roleid ?? "MR-0000", 4);
            $permission = $request->permissions;
            $data = [
                "menu_roleid"=> $newID,
                "role_id"    => $request->role_id,
                "menu_id"    => $request->menu_id,
                "submenu_id" => $request->submenu_id,
                "created_by" => $user["email"],
                "permissions"=> [
                    "menu_roleid" => $newID,
                    "is_read"     => $permission["is_read"],
                    "is_create"   => $permission["is_create"],
                    "is_update"   => $permission["is_update"],
                    "is_delete"   => $permission["is_delete"],
                    "is_export"   => $permission["is_export"],
                    "is_verify"   => $permission["is_verify"],
                    "created_by"  => $user["email"]
                ]
            ];

            DB::beginTransaction();

                $this->menuRoleRepo->store($data);
                $this->rolePermissionRepo->store($data["permissions"]);
            
            DB::commit();
            return response()->json(ResponseFormatter::success(201, __("Success"), $data), 201);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(ResponseFormatter::failed($e->getCode(), ERROR, $e->getMessage()), $e->getCode());       
        }
    }

    public function update(MenuRoleRequest $request, $id)
    {
        try {
            $user   = JWTAuth::getPayload($request->bearerToken())->toArray();
            $menuRoles = $this->menuRoleRepo->findWith("permissions", $id);
            if(!$menuRoles){
                return response()->json(ResponseFormatter::failed(404, __("Data Not Found"), NOT_FOUND), 404);
            }
            
            $permission = $request->permissions;
            $permit = $menuRoles->permissions[0];
            $data = [
                "menu_id"    => $request->menu_id ?? $menuRoles->menu_id,
                "submenu_id" => $request->submenu_id ?? $menuRoles->submenu_id,
                "updated_by" => $user["email"],
                "permissions"=> [
                    "is_read"     => $permission["is_read"]?? $permit["is_read"],
                    "is_create"   => $permission["is_create"] ?? $permit["is_create"],
                    "is_update"   => $permission["is_update"] ?? $permit["is_update"],
                    "is_delete"   => $permission["is_delete"] ?? $permit["is_update"],
                    "is_export"   => $permission["is_export"] ?? $permit["is_export"],
                    "is_verify"   => $permission["is_verify"] ?? $permit["is_verify"],
                    "updated_by"  => $user["email"]
                ]
            ];

            DB::beginTransaction();

                $this->rolePermissionRepo->update($id, $data["permissions"]);
                $permissions = $data;
                unset($data["permissions"]);
                $this->menuRoleRepo->update($id, $data);
            
            DB::commit();
            return response()->json(ResponseFormatter::success(201, __("Success"), $permissions), 201);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(ResponseFormatter::failed($e->getCode(), ERROR, $e->getMessage()),  500);       
        }
    }
}
