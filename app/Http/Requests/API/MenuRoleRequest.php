<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MenuRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    "role_id"     => "required|string|max:32|exists:role,role_id",
                    "menu_id"     => "required|string|max:32|exists:menu,menu_id",
                    "submenu_id"  => "nullable|string|max:32|exists:submenu,submenu_id",
                    "permissions" => "required|array",
                    "permissions.is_read"   => "required|in:0,1",
                    "permissions.is_create" => "required|in:0,1",
                    "permissions.is_update" => "required|in:0,1",
                    "permissions.is_delete" => "required|in:0,1",
                    "permissions.is_export" => "required|in:0,1",
                    "permissions.is_verify" => "required|in:0,1" 
                ];
                break;
            case 'PUT':
                return [
                    "menu_id"     => "string|max:32|exists:menu,menu_id",
                    "submenu_id"  => "nullable|string|max:32|exists:submenu,submenu_id",
                    "permissions" => "array",
                    "permissions.is_read"   => "in:0,1",
                    "permissions.is_create" => "in:0,1",
                    "permissions.is_update" => "in:0,1",
                    "permissions.is_delete" => "in:0,1",
                    "permissions.is_export" => "in:0,1",
                    "permissions.is_verify" => "in:0,1" 
                ];
                break;
            default:
                # code...
                break;
        }
       
    }
}
