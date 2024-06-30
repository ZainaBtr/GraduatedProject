<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    use HasFactory;
    protected $table = "join_requests";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'senderID',
        'groupID',
        'requestDate',
        'joiningRequestStatus'
    ];
    public function group()
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderID');
    }
}
