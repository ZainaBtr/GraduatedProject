<?php

namespace App\Http\Requests\PrivateSession;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class PrivateSession2 extends FormRequest
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
            'sessionName' => ['string', 'nullable'],
            'sessionDescription' => ['string', 'nullable'],
            'sessionDate' => ['date', 'nullable'],
            'sessionStartTime' => ['date_format:H:i', 'nullable'],
            'sessionEndTime' => ['date_format:H:i', 'nullable'],
            'durationForEachReservation' => ['regex:/^\d{1,2}:\d{1,2}$/', 'nullable']
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
