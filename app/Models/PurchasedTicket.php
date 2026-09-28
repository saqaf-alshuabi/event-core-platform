<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasedTicket extends Model
{
    /** @use HasFactory<\Database\Factories\PurchasedTicketFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['order_id', 'ticket_id', 'attendee_id', 'ticket_code', 'is_used'];

    protected $casts = [
        'is_used' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }
}
