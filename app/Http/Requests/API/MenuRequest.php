<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MenuRequest extends FormRequest
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
                    "title" => "required|string|max:20",
                    "icon"  => "string|max:60",
                    "link"  => "string|max:128",
                    "is_active" => "string|in:0,1"
                ];
                break;
            case 'PUT':
                return [
                    "title" => "string|max:20",
                    "icon"  => "string|max:60",
                    "link"  => "string|max:128",
                    "is_active" => "string|in:0,1"
                ];
                break;
            default:
                # code...
                break;
        }
    }
}
