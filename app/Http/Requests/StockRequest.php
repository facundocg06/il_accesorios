<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'name'=> 'required',
            'price'=> 'required',
            'description'=> 'required',
            'suppliers_id'=> 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio',
            'price.required' => 'El precio del producto es obligatorio',
            'description.required' => 'La descripción del producto es obligatoria',
            'suppliers_id' => 'El Proveedor es necesario'
        ];
    }
}
