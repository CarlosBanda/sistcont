<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'    => ['required', 'exists:products,id'],
            'numero_serie'  => ['required', 'string', 'max:100'],
            'codigo_barras' => ['nullable', 'string', 'max:100'],
            'garantia'      => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'   => 'Debe seleccionar un producto.',
            'product_id.exists'     => 'El producto seleccionado no existe.',
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.max'      => 'El número de serie no puede exceder 100 caracteres.',
        ];
    }
}
