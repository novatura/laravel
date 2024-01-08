<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Novatura\Laravel\Scaffold\Lib\Traits\HasEmailVerification;
use Novatura\Laravel\Scaffold\Lib\Traits\HasFile;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasEmailVerification, HasFile;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // 'two_factor_recovery_codes' => 'array',
    ];

    /**
     * The attributes should be appended to the model
     *
     * @var array<string>
     */
    protected $appends = ['full_name', 'two_factor_enabled'];


    /**
     * The method gets the full name of the user.
     *
     * @return string full name of the user
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * The method gets the two factor enabled status of the user.
     *
     * @return bool two factor enabled status of the user
     */
    public function getTwoFactorEnabledAttribute()
    {
        return !is_null($this->two_factor_secret);
    }


}
