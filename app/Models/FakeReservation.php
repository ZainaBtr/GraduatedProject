<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeReservation extends Model
{
    use HasFactory;
    protected $table = "fake_reservations";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'privateSessionID',
        'reservationStartTime',
        'reservationEndTime'
    ];

    public function privateSession()
    {
        return $this->belongsTo(PrivateSession::class,'privateSessionID');
    }
}
