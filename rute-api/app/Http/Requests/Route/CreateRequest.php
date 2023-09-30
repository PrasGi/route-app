<?php

namespace App\Http\Requests\Route;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public $validator;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'long_route' => 'required|string',
            'height_start' => 'required|numeric',
            'height_end' => 'required|numeric',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Validate each image in the array
        ];
    }
}
