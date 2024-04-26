<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceYearAndSpecialization extends Model
{
    use HasFactory;
    protected $table = "service_year_and_specializations";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'serviceYear',
        'serviceSpecializationName'
    ];
}
