<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'lastname'   => ['nullable', 'string', 'max:255'],
            'rfc'        => ['required', 'string', 'min:12', 'max:13'],
            'email'      => ['nullable', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'zip_code'   => ['required', 'string', 'max:10'],
            'address'    => ['nullable', 'string', 'max:500'],
            'number_ext' => ['nullable', 'string', 'max:20'],
            'number_int' => ['nullable', 'string', 'max:20'],
            'colony'     => ['required', 'string', 'max:255'],
            'city'       => ['nullable', 'string', 'max:255'],
            'state'      => ['nullable', 'string', 'max:255'],
            'country'    => ['nullable', 'string', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'El nombre del cliente es obligatorio.',
            'rfc.required'      => 'El RFC es obligatorio.',
            'rfc.min'           => 'El RFC debe tener al menos 12 caracteres.',
            'rfc.max'           => 'El RFC no puede exceder 13 caracteres.',
            'zip_code.required' => 'El código postal es obligatorio.',
            'colony.required'   => 'La colonia es obligatoria.',
            'email.email'       => 'El email no tiene un formato válido.',
        ];
    }
}
