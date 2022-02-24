<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductosVariaciones extends FormRequest
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
            'referencia' =>  ['required'], 
            'precio'  => ['required'], 
            'descripcion'  => ['required']
        ];
    }

    public function messages()
    {
        return [
            'referencia.required' => 'El Campo Referencia es Requerido',
            'precio.required' => 'El Campo precio es Requerido',
            'descripcion.required' => 'El Campo  descripcion es Requerido'
        ];
    }

    //Accept: aplication/json encabezado de solicitud 
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }
}
