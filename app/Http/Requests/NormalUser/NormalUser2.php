<?php

namespace App\Http\Requests\NormalUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class NormalUser2 extends FormRequest
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
            'birthDate' => ['required', 'date'],
            'motherBirthDate' => ['required', 'date'],
            'fatherBirthDate' => ['required', 'date'],
            'numberOfSisters' => ['required', 'numeric', 'between:0,30'],
            'numberOfBrothers' => ['required', 'numeric', 'between:0,30'],
            'numberOfMothersSister' => ['required', 'numeric', 'between:0,30'],
            'numberOfFathersSister' => ['required', 'numeric', 'between:0,30'],
            'numberOfMothersBrother' => ['required', 'numeric', 'between:0,30'],
            'numberOfFathersBrother' => ['required', 'numeric', 'between:0,30'],
            'favoriteColor' => ['required', 'string', 'in:Yellow,Black,White,Red,Blue,Green,Orange,Purple,Pink,Brown,Others'],
            'favoriteHobby' => ['required', 'string', 'in:Reading,Writing,Drawing,Music,Others'],
            'favoriteSport' => ['required', 'string', 'in:Tennis,Football,Basketball,Swimming,Skiing,Ping Pong,Others'],
            'favoriteSeason' => ['required', 'string', 'in:Summer,Winter,Spring,Autumn'],
            'favoriteBookType' => ['required', 'string', 'in:Scientific,Science Fiction,Cultural,Religious,Fantasy,Romance,Detective And Action,Others'],
            'favoriteTravelCountry' => ['required', 'string', 'in:Germany,France,UAE,Saudi Arabia,Switzerland,Thailand,Malaysia,Egypt,Others'],
            'favoriteFood' => ['required', 'string', 'in:Kubba,Kabsa,Pasta,Pizza,Mahashi,Grape Leaves,Shawarma,Broasted,Others'],
            'favoriteDessert' => ['required', 'string', 'in:Kunafa,Cake,Ice Cream,Qatayef,Western Sweets,Others'],
            'favoriteDrink' => ['required', 'string', 'in:Strawberry,Orange,Lemon,Tamarind,Fruits,Licorice,Mango,Carrot,Others'],
            'baccalaureateMark' => ['required', 'numeric', 'lte:240'],
            'ninthGradeMark' => ['required', 'numeric', 'lte:310']
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
