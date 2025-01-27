<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nit_supplier'=> 'required',
            'reason_social'=> 'required',
            'phone_supplier'=> 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'nit_supplier' => 'El nit del proveedor es obligatorio',
            'reason_social' => 'La razón social del proveedor es obligatoria',
            'phone_supplier' => 'El teléfono del proveedor es obligatorio',
        ];
    }
}
