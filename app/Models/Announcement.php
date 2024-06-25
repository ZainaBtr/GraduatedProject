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
        'userID',
        'fileID',
        'title',
        'description'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceID');
    }

    public function file()
    {
        return $this->hasMany(File::class, 'announcementID');
    }

    public function savedAnnouncement()
    {
        return $this->hasMany(SavedAnnouncement::class, 'announcementID');
    }
}
