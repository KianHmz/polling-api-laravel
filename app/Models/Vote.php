<?php

namespace App\Models;

// use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    // protected $connection = 'mongodb';

    protected $fillable = [
        'poll_id',
        'user_id',
        'choice_selected',
        'voted_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
