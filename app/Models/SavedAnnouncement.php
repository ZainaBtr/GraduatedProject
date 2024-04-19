<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedAnnouncement extends Model
{
    use HasFactory;
    protected $table = "saved_announcements";
    public $fillable = [
        'userID',
        'announcementID'
    ];

    public  $timestamp = true ;
}
