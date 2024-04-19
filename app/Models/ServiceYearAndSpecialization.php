<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceYearAndSpecialization extends Model
{
    use HasFactory;
    protected $table = "service_year_and_specializations";
    public $fillable = [
        'serviceYear',
        'serviceSpecializationName'
    ];

    public  $timestamp = true ;
}
