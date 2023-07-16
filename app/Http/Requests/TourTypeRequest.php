<?php

namespace App\Http\Requests;

use GuzzleHttp\Middleware;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TourTypeRequest extends FormRequest
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
            'money' => 'required|not_in:0',
            'fee1' => 'required|min:0',
            'fee2' => 'required|gt:fee1',
            'fee3' => 'required|gt:fee2',
            'fee4' => 'required|gt:fee3',
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
            'money' => __('app.money_type') ,
        ];
    }
}
