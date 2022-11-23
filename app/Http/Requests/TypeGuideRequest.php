<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeGuideRequest extends FormRequest
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
        ];
    }
}
