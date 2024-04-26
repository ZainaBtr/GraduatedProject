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
        'advancedUserID',
        'serviceID'
    ];
}
