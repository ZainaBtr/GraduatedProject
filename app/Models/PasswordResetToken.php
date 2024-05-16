<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordResetToken extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "password_reset_tokens";
    public $timestamps = false;
    public $fillable = [
        'token'
    ];
}
