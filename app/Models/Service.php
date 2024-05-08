<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $primaryKey = "id";
    public $timestamp = true ;
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

    public function serviceManager()
    {
        return $this->belongsTo(ServiceManager::class, 'serviceManagerID');
    }

    public function parentService()
    {
        return $this->belongsTo(Service::class, 'parentServiceID');
    }

    public function serviceYearAndSpecialization()
    {
        return $this->belongsTo(ServiceYearAndSpecialization::class, 'serviceYearAndSpecializationID');
    }

    public function assignedService()
    {
        return $this->hasMany(AssignedService::class, 'serviceID');
    }

    public function interestedService()
    {
        return $this->hasMany(InterestedService::class, 'serviceID');
    }
}
