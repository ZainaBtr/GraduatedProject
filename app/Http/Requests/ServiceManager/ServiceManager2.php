<?php

namespace App\Http\Requests\ServiceManager;

use Illuminate\Foundation\Http\FormRequest;

class ServiceManager2 extends FormRequest
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
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'email', 'unique:services_managers']
        ];
    }
}
