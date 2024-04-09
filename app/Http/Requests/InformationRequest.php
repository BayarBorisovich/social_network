<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'surname' => 'nullable|string',
            'patronymic' => 'nullable|string',
            'telephone' => 'nullable|string',
            'city' => 'nullable|string',
            'about_me' => 'nullable|string',
        ];
    }
}
