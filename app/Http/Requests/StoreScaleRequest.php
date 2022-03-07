<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScaleRequest extends FormRequest
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
            'fecha'       => 'required|date',
            'ubicacion'   => 'required',
            'descripcion' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fecha.required'     => 'El campo fecha es obligatorio.',
            'ubicacion.required' => 'El campo ubicación es obligatorio.',
            'descripcion'        => 'El campo descripción es obligatorio.'
        ];
    }
}
