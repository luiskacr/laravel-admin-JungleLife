<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'description'=> 'max:75',
            //'price' => 'decimal:2',
            'type' => 'required|not_in:0' ,
            'money' => 'required|not_in:0',
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
            'description' => __('app.description'),
            'price' => __('app.price'),
            'type' =>  __('app.product_type_singular'),
            'money' => __('app.money_type') ,
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'price.decimal' => 'A title is required',
        ];
    }
}
