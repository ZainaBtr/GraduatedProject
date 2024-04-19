<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalUser extends Model
{
    use HasFactory;
    protected $table = "normal_users";
    public $fillable = [
        'userID',
        'serviceYearAndSpecializationID',
        'examinationNumber',
        'studySituation',
        'isAccountCompleted',
        'skills',
        'birthDate',
        'motherBirthDate',
        'fatherBirthDate',
        'numberOfSisters',
        'numberOfBrothers',
        'numberOfMothersSister',
        'numberOfFathersSister',
        'numberOfMothersBrother',
        'numberOfFathersBrother',
        'favoriteColor',
        'favoriteSport',
        'favoriteSeason',
        'favoriteBookType',
        'favoriteTravelCountry',
        'favoriteFood',
        'favoriteDesert',
        'favoriteDrink',
        'baccalaureateMark',
        'ninthGradeMark'
    ];

    protected $hidden = [
        'motherBirthDate',
        'fatherBirthDate',
        'numberOfSisters',
        'numberOfBrothers',
        'numberOfMothersSister',
        'numberOfFathersSister',
        'numberOfMothersBrother',
        'numberOfFathersBrother',
        'favoriteColor',
        'favoriteSport',
        'favoriteSeason',
        'favoriteBookType',
        'favoriteTravelCountry',
        'favoriteFood',
        'favoriteDesert',
        'favoriteDrink',
        'baccalaureateMark',
        'ninthGradeMark'
    ];

    public  $timestamp = true ;
}
