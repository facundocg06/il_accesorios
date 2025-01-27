<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'ci_customer' => 'required|unique:customers,ci_customer',
            'name_customer'=> 'required',
            'last_name_customer'=> 'required',
            'email_customer'=> 'required',
            'phone_customer'=> 'required',
            'address_customer'=> 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'ci_customer.required' => 'El CI del cliente es obligatorio.',
            'ci_customer.unique' => 'Este CI ya está registrado en nuestros registros.',
            'name_customer.required' => 'El nombre del cliente es obligatorio.',
            'last_name_customer.required' => 'El apellido del cliente es obligatorio.',
            'email_customer.required' => 'El correo electrónico del cliente es obligatorio.',
            'phone_customer.required' => 'El teléfono del cliente es obligatorio.',
            'address_customer.required' => 'La dirección del cliente es obligatoria.',
        ];
    }
}
