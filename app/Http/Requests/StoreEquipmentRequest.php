<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
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
            'nombre'          => 'required',
            'descripcion'     => 'required',
            'ubicacion'       => 'required',
            'precio_unitario' => 'required',
            'id_proveedor'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required'          => 'El campo "Nombre" es obligatorio.',
            'descripcion.required'     => 'El campo "Descripción" es obligatorio.',
            'ubicacion.required'       => 'El campo "Ubicación" es obligatorio.',
            'precio_unitario.required' => 'El campo "Precio unitario" es obligatorio.',
            'id_proveedor.required'    => 'El campo "Proveedor" es obligatorio.'
        ];
    }
}
