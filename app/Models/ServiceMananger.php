<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMananger extends Model
{
    use HasFactory;
    protected $table = "services_managers";
    public $fillable = [
        'userID',
        'position'
    ];

    public  $timestamp = true ;
}
