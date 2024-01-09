<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SubmenuRequest extends FormRequest
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
                    "submenu_title" => "required|string|max:32",
                    "menu_id"       => "required|string|exists:menu,menu_id",
                    "submenu_link"  => "required|string|max:128",
                    "submenu_icon"  => "string|max:64",
                    "is_active"     => "string|in:0,1"
                ];
                break;
            case 'PUT':
                return [
                    "submenu_title" => "string|max:32",
                    "menu_id"       => "string|exists:menu,menu_id",
                    "submenu_link"  => "string|max:128",
                    "submenu_icon"  => "string|max:64",
                    "is_active"     => "string|in:0,1"
                ];
                break;
            default:
                # code...
                break;
        }
    }
}
