<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
        return [
            
            "name"=> "string|max:255",
            "description"=> "string|max:255",
            "demo_link"=> "string|max:255",
            "github_link"=> "string|max:255",
            "image"=> "string|max:255",
            "status"=> "string|max:255",
        ];
    }
}
