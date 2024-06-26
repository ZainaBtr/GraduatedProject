<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = "groups";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'serviceID'
    ];



    public function sentSwapRequests()
    {
        return $this->hasMany(SwapRequest::class, 'senderGroupID');
    }

    public function receivedSwapRequests()
    {
        return $this->hasMany(SwapRequest::class, 'receiverGroupID');
    }

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'groupID');
    }
}
