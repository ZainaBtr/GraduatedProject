<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    public $fillable = [
        'serviceManagerID',
        'parentServiceID',
        'serviceYearAndSpecializationID',
        'serviceName',
        'serviceDescription',
        'serviceType',
        'minimumNumberOfGroupMembers',
        'maximumNumberOfGroupMembers',
        'status'
    ];

    public  $timestamp = true ;
}
