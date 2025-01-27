<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name_category'=> 'required',
            'description_category'=> 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name_category.required' => 'El nombre de la categoría es obligatorio',
            'description_category.required' => 'La descripción de la categoría es obligatoria',
        ];
    }
}
