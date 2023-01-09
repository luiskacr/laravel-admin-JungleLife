<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'email'=> [
                'Email',
                'required',
                'min:2',
                'max:75',
                Rule::unique('users')->ignore($this->user),
                ],
            'role'=> 'required|not_in:0',
        ];
    }


    /**
     * Set Values Display Name
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' =>  __('app.name'),
            'email' =>  __('app.email'),
            'role' =>  __('app.rol'),
        ];
    }
}
