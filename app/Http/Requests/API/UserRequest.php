<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'PUT':
                return [
                    "name"      => "string|max:64",
                    "username"  => "string|max:32",
                    "role_id"   => "string|max:12",
                    "email"     => "string|email|max:64",
                    "status"    => "string|in:0,1"
                ];
                break;
            case "POST":
                return [
                    "name"      => "required|string|max:64",
                    "username"  => "required|string|max:32",
                    "role_id"   => "required|string|max:12",
                    "email"     => "required|string|email|max:64",
                    "status"    => "required|string|in:0,1"
                ];
                break;
            default:
                # code...
                break;
        }
    }
}
