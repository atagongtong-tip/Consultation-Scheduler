<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'role_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'email' => 'required|email|max:255|regex:/(.*)@tip\.edu\.ph/i|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ];
    }
}
