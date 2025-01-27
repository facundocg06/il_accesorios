<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'purchase_date' => 'required|date',
            'total_quantity' => 'required|numeric',
            'reason_social' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*.stock_production_id' => 'required|exists:stock_productions,id',
            'products.*.amount' => 'required|numeric',
            'products.*.price_purchase_detail' => 'required|numeric'
        ];
    }
    public function messages(): array
    {
        return [
            'purchase_date'=> 'La fecha de compra es requerida',
            'total_quantity'=> 'La cantidad total es requerida',
            'reason_social'=> 'La razón social es requerida',
            'products.required'=> 'Los productos son requeridos',
            'products.*.stock_production_id'=> 'El producto es requerido',
            'products.*.amount'=> 'La cantidad es requerida',
            'products.*.price_purchase_detail'=> 'El precio de compra es requerido'
        ];
    }
}
