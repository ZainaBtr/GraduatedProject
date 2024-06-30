<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class User6 extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'email' => ['required', 'email', 'unique:users,email']
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
    }
}