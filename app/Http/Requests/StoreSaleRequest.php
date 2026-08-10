<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'  => ['required', 'exists:clients,id'],
            'user_id'    => ['required', 'exists:users,id'],
            'sale_date'  => ['nullable', 'date'],
            'folio'      => ['nullable', 'string', 'max:255'],
            'currency'   => ['nullable', 'string', 'size:3'],
            'products'   => ['required', 'array', 'min:1'],
            'products.*.product_id'     => ['required', 'exists:products,id'],
            'products.*.qty'            => ['required', 'integer', 'min:1'],
            'products.*.price'          => ['required', 'numeric', 'min:0'],
            'products.*.discount'       => ['nullable', 'numeric', 'min:0', 'max:100'],
            'products.*.tax'            => ['nullable', 'numeric', 'min:0', 'max:100'],
            'products.*.inventory_ids'  => ['required', 'array'],
            'products.*.inventory_ids.*' => ['integer', 'exists:inventories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'             => 'Debe seleccionar un cliente.',
            'client_id.exists'               => 'El cliente seleccionado no existe.',
            'user_id.required'               => 'Debe seleccionar un vendedor.',
            'user_id.exists'                 => 'El vendedor seleccionado no existe.',
            'products.required'              => 'Debe agregar al menos un producto.',
            'products.min'                   => 'Debe agregar al menos un producto.',
            'products.*.product_id.required' => 'Cada línea debe tener un producto.',
            'products.*.qty.required'        => 'La cantidad es obligatoria.',
            'products.*.qty.min'             => 'La cantidad mínima es 1.',
            'products.*.price.required'      => 'El precio es obligatorio.',
            'products.*.inventory_ids.required' => 'Debe seleccionar los códigos de inventario.',
            'products.*.inventory_ids.*.exists' => 'Uno de los códigos de inventario no existe.',
        ];
    }
}
