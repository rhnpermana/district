<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'subject',
        'booking_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Return the other participant (not the current user).
     */
    public function otherParticipant(int $authUserId): User
    {
        return $this->user_one_id === $authUserId
            ? $this->userTwo
            : $this->userOne;
    }

    /**
     * Count unread messages for a specific user in this conversation.
     */
    public function unreadCountFor(int $userId): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Find or create a conversation between two users (canonical: lower id first).
     */
    public static function findOrCreateBetween(int $userId1, int $userId2, ?string $subject = null, ?int $bookingId = null): self
    {
        [$one, $two] = $userId1 < $userId2 ? [$userId1, $userId2] : [$userId2, $userId1];

        $conv = self::firstOrCreate(
            ['user_one_id' => $one, 'user_two_id' => $two],
            ['subject' => $subject, 'booking_id' => $bookingId, 'last_message_at' => now()]
        );

        if (!$conv->wasRecentlyCreated && $subject && !$conv->subject) {
            $conv->update(['subject' => $subject]);
        }

        return $conv;
    }
}
