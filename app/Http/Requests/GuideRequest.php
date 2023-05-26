<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuideRequest extends FormRequest
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
            "name" => 'required|min:2|max:75',
            "lastName" => 'nullable|min:2|max:75',
            "type" => "required|not_in:0",
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
            'lastName' =>  __('app.lastname'),
            'type' =>  __('app.type_guides_singular'),
        ];
    }
}
