<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name'        => 'required',
            'permissions' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'El campo "Nombre del rol" es obligatorio.',
            'permissions.required' => 'Es necesario elegir, por lo menos, 1 rol.'
        ];
    }
}
