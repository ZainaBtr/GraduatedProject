<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'serviceName' => ['string'],
            'serviceDescription' => ['text'],
            'serviceType' => ['string', 'in:lectures,exams,projects interviews,advanced users interviews,activities,others'],
            'serviceYearAndSpecializationName' => ['string', 'unique:services'],
            'minimumNumberOfGroup' => ['numeric'],
            'maximumNumberOfGroup' => ['numeric'],
            'status' => ['boolean', 'in:effective,not effective']
        ];
    }
}
