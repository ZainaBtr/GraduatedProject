<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicReservation extends Model
{
    use HasFactory;
    protected $table = "public_reservations";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'userID',
        'publicSessionID'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'userID');
    }

    public function publicSession(){
        return $this->belongsTo(PublicSession::class, 'publicSessionID');
    }
}
