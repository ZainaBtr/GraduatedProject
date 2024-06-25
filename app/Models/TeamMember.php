<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $table = "team_members";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'normalUserID',
        'groupID'
    ];

    public function normalUser()
    {
        return $this->belongsTo(NormalUser::class, 'normalUserID');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function service()
    {
        return $this->group->belongsTo(Service::class, 'serviceID');
    }

}
