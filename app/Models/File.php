<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = "files";
    protected $primaryKey = "id";
    public $timestamp = true ;
    public $fillable = [
        'announcementID',
        'fileName',
        'filePath'
    ];
}
