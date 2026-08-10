<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_model' => ['required', 'string', 'max:100'],
            'product_name'  => ['required', 'string', 'max:255'],
            'product_unit'  => ['required', 'integer'],
            'prices'        => ['required', 'array', 'min:1'],
            'prices.*.type'  => ['required', 'string', 'max:50'],
            'prices.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_model.required' => 'El modelo del producto es obligatorio.',
            'product_name.required'  => 'El nombre del producto es obligatorio.',
            'product_unit.required'  => 'La unidad de medida es obligatoria.',
            'prices.required'        => 'Debe agregar al menos un precio.',
            'prices.*.type.required' => 'Cada precio debe tener un tipo.',
            'prices.*.price.required' => 'Cada precio debe tener un valor.',
            'prices.*.price.min'     => 'El precio no puede ser negativo.',
        ];
    }
}
