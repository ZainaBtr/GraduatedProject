<?php

namespace App\Http\Requests\NormalUser;

use Illuminate\Foundation\Http\FormRequest;

class NormalUser5 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:normal_users']
        ];
    }
}
