<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperatorRequest extends FormRequest
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
            'nombre'        => 'required',
            'apellidos'     => 'required',
            'telefono'      => 'required',
            'no_licencia'   => 'required',
            'tipo_licencia' => 'required',
            'fecha_exp'     => 'required|date',
            'fecha_venc'    => 'required|date|after:fecha_exp',
            'lugar_exp'     => 'required',
            'antiguedad'    => 'required',
            'iave'          => 'required',
            'ex_medico'     => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required'            => 'El campo "Nombres" es obligatorio.',
            'apellidos.required'         => 'El campo "Apellidos" es obligatorio.',
            'telefono.required'          => 'El campo "Telefono" es obligatorio.',
            'no_licencia.required'       => 'El campo "Numero de licencia" es obligatorio.',
            'tipo_licencia.required'     => 'El campo "Tipo de licencia" es obligatorio.',
            'fecha_exp.required'         => 'El campo "Fecha de otorgamiento de la licencia" es obligatorio.',
            'fecha_venc.required'        => 'El campo "Fecha de caducidad de la licencia" es obligatorio.',
            'fecha_venc.after'           => 'El campo "Fecha de caducidad de la licencia" debe ser una fecha posterior a la fecha de otorgamiento de la licencia.',
            'lugar_exp.required'         => 'El campo "Lugar de otorgamiento de la licencia" es obligatorio.',
            'antiguedad.required'        => 'El campo "Antiguedad del operador" es obligatorio.',
            'iave.required'              => 'El campo "IAVE" es obligatorio.',
            'ex_medico.required'         => 'El campo "Fecha del ultimo examen medico" es obligatorio.'
        ];
    }
}
