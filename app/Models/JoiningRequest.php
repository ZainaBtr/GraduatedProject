<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoiningRequest extends Model
{
    use HasFactory;
    protected $table = "joining_requests";
    public $fillable = [
        'normalUserID',
        'groupID',
        'requestDate',
        'joinigRequestStatus'
    ];

    public  $timestamp = true ;
}
