<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public static function getRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            //'files' => 'required',
            'category_id' => 'required|integer',
            'brand_id' => 'required',
            'barcode' => 'required',


            'files' => 'nullable',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public static function getMessages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.string' => 'El nombre del producto debe ser una cadena de texto.',
            'name.max' => 'El nombre del producto no puede tener más de 255 caracteres.',

            'description.required' => 'La descripción del producto es obligatoria.',
            'description.string' => 'La descripción del producto debe ser una cadena de texto.',
            'description.max' => 'La descripción del producto no puede tener más de 255 caracteres.',

            'price.required' => 'El precio del producto es obligatorio.',
            'price.numeric' => 'El precio del producto debe ser un número.',

            'files.required' => 'El archivo del producto es obligatorio.',

            'category_id.required' => 'La categoría del producto es obligatoria.',
            'category_id.integer' => 'La categoría del producto seleccionada no es válida.',

            'brand_id.required' => 'La marca del producto es obligatoria.',
            'brand_id.integer' => 'La marca del producto seleccionada no es válida.',

            'barcode.required' => 'El código de barras del producto es obligatorio.',


        ];
    }
}
