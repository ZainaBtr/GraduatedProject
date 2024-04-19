<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestedService extends Model
{
    use HasFactory;
    protected $table = "interested_services";
    public $fillable = [
        'userID',
        'serviceID'
    ];

    public  $timestamp = true ;
}
