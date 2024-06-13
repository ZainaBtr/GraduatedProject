<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestedService extends Model
{
    use HasFactory;
    protected $table = "interested_services";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'userID',
        'serviceID'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceID');
    }
}
