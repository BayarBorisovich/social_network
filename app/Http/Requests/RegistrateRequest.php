<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrateRequest extends FormRequest
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
            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'required|string',
            'email' => 'required|string|email|unique:users',
//            'password' => 'required|string', //confirmed
            'phone' => 'required|string|max:14',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'about_of_me' => 'string|nullable',
        ];
    }
}
