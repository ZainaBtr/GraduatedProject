<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedAnnouncement extends Model
{
    use HasFactory;
    protected $table = "saved_announcements";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'userID',
        'announcementID'
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcementID');
    }
}
