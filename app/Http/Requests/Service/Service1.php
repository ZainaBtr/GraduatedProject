<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class Service1 extends FormRequest
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
        $parentService = $this->route('parentService');

        return [
            'serviceName' => ['required', 'string',
                Rule::unique('services')
                ->where('serviceYearAndSpecializationID', $this->input('serviceYearAndSpecializationID'))
                ->where('parentServiceID', $parentService)
            ],
            'serviceDescription' => ['required', 'string'],
            'serviceType' => ['required', 'string', 'in:lectures,exams,projects interviews,advanced users interviews,activities,others'],
            'serviceYearAndSpecializationID' => ['required', 'numeric'],
            'minimumNumberOfGroupMembers' => ['required', 'numeric', 'gte:0'],
            'maximumNumberOfGroupMembers' => ['required', 'numeric', 'gte:0'],
            'status' => ['required', 'boolean']
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
