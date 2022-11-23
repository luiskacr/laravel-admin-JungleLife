<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientTypeRequest extends FormRequest
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
            'name'=> 'required|min:2|max:75',
            'rate'=> 'numeric|min:0|max:100'
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
            'name.max'=> 'El tamano maximo es de 75 caracteres',
            'name.min'=> 'El tamano minimo es de 2 caracteres',
            'rate.numeric' => 'La Tasa debe de ser un numero',
            'rate.min' => 'La Tasa no puede ser menor a O',
            'rate.max' => 'La Tasa no puede ser Mayor a 10O',
        ];
    }
}
