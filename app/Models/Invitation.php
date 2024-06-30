<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $table = "invitations";
    protected $primaryKey = "id";
    public $timestamps = true;
    public $fillable = [
        'groupID',
        'normalUserID',
        'requestDate',
        'status'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'groupID');
    }

    public function normalUser()
    {
        return $this->belongsTo(NormalUser::class, 'normalUserID');
    }
}
