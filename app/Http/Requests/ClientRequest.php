<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:150',
            'email'=> 'required|min:2|max:75|unique:customers,email',
            'telephone' => 'max:75',
            'clientType'=> 'required|not_in:0',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'=> 'El Nombre es obligatorio',
            'name.max'=> 'El tamano maximo es de 150 caracteres',
            'name.min'=> 'El tamano minimo es de 2 caracteres',
            'email.required'=> 'El Nombre es obligatorio',
            'email.max'=> 'El tamano maximo es de 75 caracteres',
            'email.min'=> 'El tamano minimo es de 2 caracteres',
            'email.unique'=> 'El correo ya esta utilizado',
            'telephone.max' => 'El tamano maximo es de 75 caracteres',
            'clientType.required'=> 'Debe de Seleccionar un tipo de Guia',
            'clientType.not_in'=> 'Debe de Seleccionar un tipo de Guia',
        ];
    }
}
