<?php

namespace App\Http\Requests\PublicSession;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PublicSession2 extends FormRequest
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
            'maximumNumberOfReservations' => ['numeric',
                Rule::gt(DB::table('public_sessions')->value('maximumNumberOfReservations'))
            ]
        ];
    }
}
