<?php

namespace App\Http\Requests;

use App\Rules\ArrayUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

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
            'salida.required'              => Lang::get('routesCreate.salida_required'),
            'salida.min'                   => Lang::get('routesCreate.salida_min'),
            'fecha_salida.required'        => Lang::get('routesCreate.fecha_salida_required'),
            'destino.required'             => Lang::get('routesCreate.destino_required'),
            'destino.min'                  => Lang::get('routesCreate.destino_min'),
            'fecha_destino.required'       => Lang::get('routesCreate.fecha_destino_required'),
            'fecha_destino.after_or_equal' => Lang::get('routesCreate.fecha_destino_after_or_equal'),
            'descripcion.required'         => Lang::get('routesCreate.descripcion_required'),
            'unidad.required'              => Lang::get('routesCreate.unidad_required'),
            'operator.required'            => Lang::get('routesCreate.operator_required'),
            'contenedores.required'        => Lang::get('routesCreate.contenedores_required'),
            'equipment.required'           => Lang::get('routesCreate.equipment_required')
        ];
    }
}
