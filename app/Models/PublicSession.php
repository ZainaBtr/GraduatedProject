<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicSession extends Model
{
    use HasFactory;
    protected $table = "public_sessions";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'sessionID',
        'MaximumNumberOfReservations'
    ];
}
