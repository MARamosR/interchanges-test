<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'proveedor' => 'required|min:6',
            'direccion' => 'required|min:6',
            'ciudad'    => 'required|min:3',
            'telefono'  => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'proveedor.required' => 'El campo "Proveedor" es obligatorio.',
            'proveedor.min'      => 'El campo "Proveedor" debe tener por lo menos 6 caracteres.',
            'direccion.required' => 'El campo "Dirección" es obligatorio.',
            'direccion.min'      => 'El campo "Dirección" debe tener por lo menos 6 caracteres.',
            'ciudad.required'    => 'El campo "Ciudad" es obligatorio.',
            'ciudad.min'         => 'El campo "Ciudad" debe tener por lo menos 3 caracteres.',
            'telefono.required'  => 'El campo "Teléfono" es obligatorio.',
            'telefono.integer'   => 'El campo "Teléfono" debe contener únicamente números.',
        ];
    }
}
