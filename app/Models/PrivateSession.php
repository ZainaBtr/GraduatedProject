<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateSession extends Model
{
    use HasFactory;
    protected $table = "private_sessions";
    public $fillable = [
        'sessionID',
        'DurationForEachReservation'
    ];

    public  $timestamp = true ;
}
