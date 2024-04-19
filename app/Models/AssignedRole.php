<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedRole extends Model
{
    use HasFactory;
    protected $table = "assigned_roles";
    public $fillable = [
        'assignedServiceID',
        'roleID'
    ];

    public  $timestamp = true ;
}
