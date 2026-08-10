<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'      => ['required', 'exists:clients,id'],
            'user_id'        => ['required', 'exists:users,id'],
            'contact_name'   => ['nullable', 'string', 'max:255'],
            'quotation_date' => ['required', 'date'],
            'currency'       => ['nullable', 'string', 'size:3'],
            'subtotal'       => ['nullable', 'numeric', 'min:0'],
            'discount_total' => ['nullable', 'numeric', 'min:0'],
            'tax_total'      => ['nullable', 'numeric', 'min:0'],
            'grand_total'    => ['nullable', 'numeric', 'min:0'],
            'products'       => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.barcode'    => ['nullable', 'string'],
            'products.*.qty'        => ['required', 'integer', 'min:1'],
            'products.*.price'      => ['required', 'numeric', 'min:0'],
            'products.*.discount'   => ['nullable', 'numeric', 'min:0', 'max:100'],
            'products.*.tax'        => ['nullable', 'numeric', 'min:0', 'max:100'],
            'products.*.total'      => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'           => 'Debe seleccionar un cliente.',
            'client_id.exists'             => 'El cliente seleccionado no existe.',
            'user_id.required'             => 'Debe seleccionar un vendedor.',
            'quotation_date.required'      => 'La fecha de cotización es obligatoria.',
            'quotation_date.date'          => 'La fecha no tiene un formato válido.',
            'products.required'            => 'Debe agregar al menos un producto.',
            'products.min'                 => 'Debe agregar al menos un producto.',
            'products.*.product_id.required' => 'Cada línea debe tener un producto.',
            'products.*.qty.required'      => 'La cantidad es obligatoria.',
            'products.*.qty.min'           => 'La cantidad mínima es 1.',
            'products.*.price.required'    => 'El precio es obligatorio.',
            'products.*.total.required'    => 'El total de cada línea es obligatorio.',
        ];
    }
}
