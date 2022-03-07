<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'placa'  => 'required',
            'marca'  => 'required',
            'modelo' => 'required',
            'anio'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'placa.required'  => 'El campo "Placa" es obligatorio.',
            'marca.required'  => 'El campo "Marca" es obligatorio.',
            'modelo.required' => 'El campo "Modelo" es obligatorio.',
            'anio.required'   => 'El campo "Año" es obligatorio.'
        ];
    }
}
