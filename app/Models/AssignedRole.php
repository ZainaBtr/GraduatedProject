<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedRole extends Model
{
    use HasFactory;
    protected $table = "assigned_roles";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'assignedServiceID',
        'roleID'
    ];
}
