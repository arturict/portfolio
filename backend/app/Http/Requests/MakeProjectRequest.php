<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeProjectRequest extends FormRequest
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
            "name"=> "required|string|max:255",
            "title"=> "string|max:255",
            "description"=> "nullable|string|max:1000",
            "demo_link"=> "nullable|url|max:255",
            "github_link"=> "nullable|url|max:255",
            "image"=> "nullable|url|max:255",
            "status"=> "required|string|max:10|in:planned,current,finished",
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // If 'name' is provided but 'title' is not, use 'name' as 'title'
        if ($this->has('name') && !$this->has('title')) {
            $this->merge(['title' => $this->input('name')]);
        }
        
        // If 'title' is provided but 'name' is not, use 'title' as 'name'
        if ($this->has('title') && !$this->has('name')) {
            $this->merge(['name' => $this->input('title')]);
        }
    }
}