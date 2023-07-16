<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

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
            'price' => 'min:1',
            'type' => 'required|not_in:0' ,
            'money' => 'required|not_in:0',
            'tourType' => [
                function ($attribute, $value, $fail) {
                    if ($this->type == 1 && $value == 0) {
                        $fail('El campo Tipo de tour es obligatorio.');
                    }
                },
            ],
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
            'tourType' => __('app.tour_type_singular')
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
