<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'colour',
    ];

    protected $with = [
        'permissions'
    ];

    protected $appends = [
        'user_count'
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function getUserCountAttribute()
    {
        return $role->users->count();
    }

}
