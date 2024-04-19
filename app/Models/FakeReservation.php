<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeReservation extends Model
{
    use HasFactory;
    protected $table = "fake_reservations";
    public $fillable = [
        'privateSessionID',
        'reservationDate'
    ];

    public  $timestamp = true ;
}
