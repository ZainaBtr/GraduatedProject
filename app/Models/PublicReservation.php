<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicReservation extends Model
{
    use HasFactory;
    protected $table = "public_reservations";
    public $fillable = [
        'normalUserID',
        'publicSessionID'
    ];

    public  $timestamp = true ;
}
