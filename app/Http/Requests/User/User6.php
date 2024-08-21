<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class User6 extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'email' => ['required', 'email', 'unique:users,email'],
            'deviceToken' => ['required', 'string']
        ];

        if (request()->is('api/*')) {
            if (Auth::guard('api')->guest()) {
                $rules['password'] = ['required', 'string', 'min:8'];
            }
        } else {
            if (Auth::guard('web')->guest()) {
                $rules['password'] = ['required', 'string', 'min:8'];
            }
        }

        return $rules;
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
