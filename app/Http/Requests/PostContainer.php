<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostContainer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Autoriza o no al usuario que hace el request.
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
            'serie'          => 'required',
            'marca'          => 'required',
            'modelo'         => 'required',
            'placa'          => 'required',
            'comentario'     => 'required',
            'placa_mx'       => 'required',
            'placa_ant'      => 'required',
            'ubicacion'      => 'required',
            'riel_logistico' => 'required',
            'canastilla'     => 'required',
            'tipo_placa'     => 'required',
            'propietario'    => 'required',
            'ancho'          => 'required',
            'largo'          => 'required',
            'alto'           => 'required',
            'llanta'         => 'required',
            'llanta_status'  => 'required',
            'tipo_caja'      => 'required',
        ];
    }
}
