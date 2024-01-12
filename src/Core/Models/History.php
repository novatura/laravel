<?php

namespace Novatura\Laravel\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'action',
        'model',
        'model_id',
        'old_data',
        'new_data',
        'user_id'
    ];

    protected $casts = [
        'old_data' => 'json',
        'new_data' => 'json',
    ];

    protected $with =['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
