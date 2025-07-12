<?php

namespace App\Models;

// use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Poll extends Model
{
    use HasFactory, Notifiable;

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
