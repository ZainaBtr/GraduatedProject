<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceManager extends Model
{
    use HasFactory;
    protected $table = "services_managers";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'userID',
        'position'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
