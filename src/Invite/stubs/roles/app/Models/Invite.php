<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'invite_roles');
    }
}
