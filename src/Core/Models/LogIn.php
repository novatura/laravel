<?php

namespace Novatura\Laravel\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'browser',
        'ip',
        'user_id'
    ];
}
