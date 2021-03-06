<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'login' => [
                'required',
                'max:255',
                'min:3',
                'string',
                Rule::exists('users', 'login')
            ],
            'password' => [
                'required',
                'max:255',
                'min:3',
                'string',
            ]
        ];
    }
}
