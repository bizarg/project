<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FtpSettingsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'address' => 'required|ip',
            'port' => 'integer|min:10|max:9999',
            'login' => 'required',
            'password' => 'required',
        ];
    }

    /*public function messages()
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.required' => 'The email address field is required.',
            'email.email' => 'The email address specified is not a valid email address.',
            'email.unique' => 'The email address is already registered with this website.',
            'dob.required' => 'The date of birth field is required.',
            'dob.regex' => 'The date of birth is invalid. Please use the following format: DD/MM/YYYY.',
            'dob.valid_date' => 'The date of birth is invalid. Please check and try again.',
            'mobile.required' => 'The mobile number field is required.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The confirm password field does not match the password field.'
        ];
    }*/
}
