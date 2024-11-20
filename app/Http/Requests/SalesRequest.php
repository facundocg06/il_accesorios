<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'ci_customer' => 'required|string|max:255',
            'phone_customer' => 'required|string|max:255',
            'name_customer' => 'required|string|max:255',
            'email_customer' => 'required|email|max:255',
            'products' => 'required|array|min:1',
            'products.*.item' => 'required|string|max:255',
            'products.*.variety_id' => 'required|integer',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ci_customer.required' => 'El campo CI del cliente es obligatorio.',
            'phone_customer.required' => 'El campo teléfono del cliente es obligatorio.',
            'name_customer.required' => 'El campo nombre del cliente es obligatorio.',
            'email_customer.required' => 'El campo correo electrónico del cliente es obligatorio.',
            'email_customer.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'products.required' => 'Debe agregar al menos un producto.',
            'products.*.item.required' => 'El nombre del producto es obligatorio.',
            'products.*.variety_id.required' => 'El ID de variedad del producto es obligatorio.',
            'products.*.variety_id.integer' => 'El ID de variedad del producto debe ser un número entero.',
            'products.*.price.required' => 'El precio del producto es obligatorio.',
            'products.*.price.numeric' => 'El precio del producto debe ser un número.',
            'products.*.price.min' => 'El precio del producto no puede ser menor que cero.',
            'products.*.quantity.required' => 'La cantidad del producto es obligatoria.',
            'products.*.quantity.integer' => 'La cantidad del producto debe ser un número entero.',
            'products.*.quantity.min' => 'La cantidad del producto no puede ser menor que uno.',
        ];
    }
}
