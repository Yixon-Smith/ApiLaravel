<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreProductos extends FormRequest
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
            'referencia_precio' =>  ['required'], 
            'cantidad'  => ['required'], 
            'descripcion'  => ['required']
        ];
    }

    public function messages()
    {
        return [
            'message' => 'Error en petición',
            'referencia_precio.required' => 'El Campo Referencia Precio es Requerido',
            'cantidad.required' => 'El Campo cantidad es Requerido',
            'descripcion.required' => 'El Campo  descripcion es Requerido'
        ];
    }

    //Accept: aplication/json encabezado de solicitud 
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }
}
