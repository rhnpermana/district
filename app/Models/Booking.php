<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch',
        'service',
        'booking_date',
        'booking_time',
        'status',
        'stylist_id',
        'queue_number',
        'type',
        'arrived_at',
        'price',
    ];

    /**
     * Get the customer that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hair stylist assigned to the booking.
     */
    public function stylist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }

    /**
     * Get the completed payment transaction for this booking if any.
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->where('payment_status', 'paid');
    }

    /**
     * Extract price integer from service string.
     */
    public function getPriceAttribute(): int
    {
        if (preg_match('/IDR\s*([\d\.]+)/i', $this->service, $matches)) {
            return (int) str_replace('.', '', $matches[1]);
        }
        return 0;
    }

    /**
     * Get formatted price string.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
