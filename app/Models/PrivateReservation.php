<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateReservation extends Model
{
    use HasFactory;
    protected $table = "private_reservations";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'groupID',
        'privateSessionID',
        'reservationDate',
        'privateReservationStatus'
    ];
}
