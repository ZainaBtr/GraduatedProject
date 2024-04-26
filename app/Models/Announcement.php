<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $table = "announcements";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'serviceID',
        'fileID',
        'title',
        'description'
    ];
}
