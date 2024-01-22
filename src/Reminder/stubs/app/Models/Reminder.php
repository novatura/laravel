<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['scheduled_at', 'query', 'condition_callback', 'notification_class', 'user_id'];

    // Add any additional relationships or methods you need

    public function getQueryAttribute()
    {
        return unserialize($this->attributes['query']);
    }

    public function setQueryAttribute($value)
    {
        $this->attributes['query'] = serialize($value);
    }

    public function getConditionCallbackAttribute()
    {
        return unserialize($this->attributes['condition_callback']);
    }

    public function setConditionCallbackAttribute($value)
    {
        $this->attributes['condition_callback'] = serialize($value);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
