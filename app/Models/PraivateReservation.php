<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PraivateReservation extends Model
{
    use HasFactory;
    protected $table = "private_reservations";
    public $fillable = [
        'groupID',
        'privateSessionID',
        'reservationDate',
        'privateReservationStatus'
    ];

    public  $timestamp = true ;
}
