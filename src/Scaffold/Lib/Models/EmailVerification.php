<?php

namespace Novatura\Laravel\Scaffold\Lib\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'email', 'user_id'];
}
