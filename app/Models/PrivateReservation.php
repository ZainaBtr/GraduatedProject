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
        'reservationStartTime',
        'reservationEndTime',
        'privateReservationStatus'
    ];

    public function senderGroup()
    {
        return $this->belongsTo(Group::class, 'senderGroupID');
    }

    public function receiverGroup()
    {
        return $this->belongsTo(Group::class, 'receiverGroupID');
    }

    public function Reservation()
    {
        return $this->belongsTo(PrivateReservation::class, 'privateReservationID');
    }

    public function privateSession()
    {
        return $this->belongsTo(PrivateSession::class, 'privateSessionID');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

}
