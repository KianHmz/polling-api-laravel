<?php

namespace App\Models;

// use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    // protected $connection = 'mongodb';

    protected $fillable = [
        'title',
        'description',
        'choices',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'choices' => 'array',
        'expires_at' => 'datetime',
    ];

    public function vote()
    {
        return $this->hasMany(Vote::class);
    }
}
