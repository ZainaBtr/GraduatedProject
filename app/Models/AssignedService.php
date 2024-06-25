<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedService extends Model
{
    use HasFactory;
    protected $table = "assigned_services";
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

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function assignedRole()
    {
        return $this->hasMany(AssignedRole::class, 'assignedServiceID');
    }
}
