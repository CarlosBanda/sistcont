<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_comercial' => ['required', 'string', 'max:255'],
            'rfc'            => ['required', 'string', 'min:12', 'max:13'],
            'razon_social'   => ['required', 'string', 'max:255'],
            'status'         => ['nullable', 'string', 'max:50'],
            'cp'             => ['nullable', 'string', 'max:10'],
            'ciudad'         => ['nullable', 'string', 'max:255'],
            'num_ext'        => ['nullable', 'string', 'max:20'],
            'municipio'      => ['nullable', 'string', 'max:255'],
            'colonia'        => ['nullable', 'string', 'max:255'],
            'address'        => ['nullable', 'string', 'max:500'],
            'pais'           => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_comercial.required' => 'El nombre comercial es obligatorio.',
            'rfc.required'            => 'El RFC del proveedor es obligatorio.',
            'rfc.min'                 => 'El RFC debe tener al menos 12 caracteres.',
            'rfc.max'                 => 'El RFC no puede exceder 13 caracteres.',
            'razon_social.required'   => 'La razón social es obligatoria.',
        ];
    }
}
