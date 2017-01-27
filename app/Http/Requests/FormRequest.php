<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:5',
            'email' => 'required|unique:users|max:30',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
              'name.required'=>'Do not forget your name',
              'email.required'=>'Email address is required.',
              'email.unique'=>'Email address has already been registered.',
              'name.max'=>'Your name have less than 5 letters?',
              'password.min'=>'Password need to be more than 6 characters.',
              'password.confirmed'=>'Password need to match.',
        ];
    }
}
