<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'location', 'start_date', 'end_date', 'organizer_id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public function eventImages(): HasMany
    {
        return $this->hasMany(EventImage::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
