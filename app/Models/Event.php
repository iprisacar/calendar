<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function eventDates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventDate::class);
    }
}
