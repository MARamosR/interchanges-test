<?php

namespace App\Http\Requests;

use App\Rules\ArrayUnique;
use Illuminate\Foundation\Http\FormRequest;

class StoreRouteRequest extends FormRequest
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
            'salida'        => 'required|min:3',
            'fecha_salida'  => 'required|date',
            'destino'       => 'required|min:3',
            'fecha_destino' => 'required|date|after_or_equal:fecha_salida',
            'descripcion'   => 'required',
            'unidad'        => 'required',
            'operador'      => 'required',
            'contenedores'  => ['required', new ArrayUnique],
            'equipment'     => ['required', new ArrayUnique]
        ];
    }

    public function messages()
    {
        return [
            'salida.required'              => 'El campo "Salida" es obligatorio.',
            'salida.min'                   => 'Salida" debe contener por lo menos 3 caracteres.',
            'fecha_salida.required'        => 'El campo "Fecha de salida" es obligatorio.',
            'destino.required'             => 'El campo "Destino" es obligatorio.',
            'destino.min'                  => 'El campo "Destino" debe contener por lo menos 3 caracteres',
            'fecha_destino.required'       => 'El campo "Fecha de llegada" es obligatorio.',
            'fecha_destino.after_or_equal' => 'El campo "Fecha de destino" no puede ser antes de la fecha de salida.',
            'descripcion.required'         => 'El campo "Descripción" es obligatorio.',
            'unidad.required'              => 'Se requiere una unidad para poder registrar la ruta.',
            'operator.required'            => 'Se requiere un operador para poder registrar la ruta.',
            'contenedores.required'        => 'Se requiere por lo menos 1 contenedor para poder registrar la ruta.',
            'equipment.required'           => 'Se requiere por lo menos 1 equipo de sujeción para poder registrar la ruta.'
        ];
    }
}
