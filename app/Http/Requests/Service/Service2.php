<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class Service2 extends FormRequest
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
        $service = $this->route('service');

        return [
            'serviceName' => ['string',
                Rule::unique('services')
                    ->where('serviceYearAndSpecializationID', $this->input('serviceYearAndSpecializationID'))
                    ->where('parentServiceID', $service['parentServiceID'])
                    ->ignore($service)
            ],
            'serviceDescription' => ['string'],
            'serviceType' => ['string', 'in:lectures,exams,projects interviews,advanced users interviews,activities,others'],
            'serviceYearAndSpecializationID' => ['numeric'],
            'minimumNumberOfGroupMembers' => ['numeric'],
            'maximumNumberOfGroupMembers' => ['numeric'],
            'status' => ['boolean']
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
