<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancedUser extends Model
{
    use HasFactory;
    protected $table = "advanced_users";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'userID'
    ];
}
