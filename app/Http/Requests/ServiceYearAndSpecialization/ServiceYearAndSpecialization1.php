<?php

namespace App\Http\Requests\ServiceYearAndSpecialization;

use Illuminate\Foundation\Http\FormRequest;

class ServiceYearAndSpecialization1 extends FormRequest
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
            'serviceYear' => ['required', 'numeric'],
            'serviceSpecializationName' => ['required', 'string']
        ];
    }
}
