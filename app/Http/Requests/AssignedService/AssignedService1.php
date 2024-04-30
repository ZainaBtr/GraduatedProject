<?php

namespace App\Http\Requests\AssignedService;

use Illuminate\Foundation\Http\FormRequest;

class AssignedService1 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'serviceName' => ['required', 'string', 'unique:assigned_services']
        ];
    }
}
