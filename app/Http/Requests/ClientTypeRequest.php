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
            'rate'=> 'numeric|min:1|max:10000',
            'moneyType'=> "required|not_in:0",
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
            'rate' =>  __('app.price'),
            'moneyType' =>  __('app.money_type'),
        ];
    }

}
