<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class UpdateUserPasswordRequest extends FormRequest
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
            'current_password' => 'required|min:2|max:75',
            'new_password' => ['required',Password::default()->letters()],
            'new_confirm_password' => ['required','same:new_password'],
        ];
        /**
         * Other Password confirmations
         * Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),
         *
         */
    }



    /**
     * Set Values Display Name
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'current_password' =>  __('app.old_passwords'),
            'new_password' =>  __('app.new_passwords'),
            'new_confirm_password' =>  __('app.confirm_passwords'),
        ];
    }
}
