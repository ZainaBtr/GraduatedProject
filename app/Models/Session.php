<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $table = "sessionss";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'userID',
        'serviceID',
        'sessionName',
        'sessionDescription',
        'sessionDate',
        'sessionStartTime',
        'sessionEndTime',
        'status',
        'password'
    ];

    public function service(){
        return $this->belongsTo(Service::class, 'serviceID');
    }

    public function privateSession(){
        return $this->hasOne(PrivateSession::class,'sessionID');
    }

    public function publicSession(){
        return $this->hasOne(PublicSession::class,'sessionID');
    }

}
