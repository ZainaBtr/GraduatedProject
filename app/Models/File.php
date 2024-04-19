<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = "files";
    public $fillable = [
        'file_name',
        'file_path',
    ];

    public  $timestamp = true ;

}
