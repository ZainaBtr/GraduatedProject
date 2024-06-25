<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateSession extends Model
{
    use HasFactory;
    protected $table = "private_sessions";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'sessionID',
        'durationForEachReservation'
    ];

    public function session(){
        return $this->belongsTo(Session::class,'sessionID');
    }

    public function fakeReservation(){
        return $this->hasMany(FakeReservation::class,'privateSessionID');
    }

    public function privateReservation(){
        return $this->hasMany(PrivateReservation::class,'privateSessionID');
    }

}
