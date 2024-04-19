<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedService extends Model
{
    use HasFactory;
    protected $table = "assigned_services";
    public $fillable = [
        'advancedUserID',
        'serviceID'
    ];

    public  $timestamp = true ;
}
