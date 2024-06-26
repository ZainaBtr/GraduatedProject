<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwapRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'privateReservationID',
        'senderGroupID',
        'receiverGroupID',
        'status'
    ];

    public function senderGroup()
    {
        return $this->belongsTo(Group::class, 'senderGroupID');
    }

    public function receiverGroup()
    {
        return $this->belongsTo(Group::class, 'receiverGroupID');
    }

    public function privateReservation()
    {
        return $this->belongsTo(PrivateReservation::class, 'privateReservationID');
    }

}
