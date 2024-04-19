<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $table = "sessionss";
    public $fillable = [
        'serviceID',
        'sessionName',
        'sessionDescription',
        'startSessionDate',
        'closeSessionDate',
        'sessionDuration',
    ];

    public  $timestamp = true ;
}
