<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email'=> [
                'required',
                'min:2',
                'max:75',
                Rule::unique('customers')->ignore($this->id),
            ],
            'telephone' => 'max:75',
            'clientType'=> 'required|not_in:0',
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
            'telephone' =>  __('app.telephone'),
            'clientType' =>  __('app.type_client_singular'),
        ];
    }
}
