<?php

namespace App\Models;

use App\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['event_id', 'attendee_id', 'total_price', 'status'];

    protected $casts = [
        'total_price' => 'decimal:2',
        'status' => OrderStatus::class,
    ];

    protected $appends = ['statusLabel', 'statusColor'];

    public function getStatusLabelAttribute(): string
    {
        return $this->status->statusLabel();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->statusColor();
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function purchasedTickets(): HasMany
    {
        return $this->hasMany(PurchasedTicket::class);
    }
}
