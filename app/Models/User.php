<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'security_pin', 'role', 'phone', 'otp_code', 'otp_expires_at'])]
#[Hidden(['password', 'remember_token', 'security_pin'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'security_pin',
        'role',
        'phone',
        'otp_code',
        'otp_expires_at',
        'work_status',
        'commission_rate',
        'avatar',
        'bio',
        'address',
        'date_of_birth',
        'gender',
        'loyalty_points',
        'member_tier',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'stylist_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'stylist_id');
    }

    public function clientNotes()
    {
        return $this->hasMany(ClientNote::class, 'customer_id');
    }

    public function workShifts()
    {
        return $this->hasMany(WorkShift::class, 'user_id');
    }

    // ─── Mailbox Relationships ────────────────────────────────────────────────

    public function conversationsAsOne()
    {
        return $this->hasMany(Conversation::class, 'user_one_id');
    }

    public function conversationsAsTwo()
    {
        return $this->hasMany(Conversation::class, 'user_two_id');
    }

    /**
     * Get all conversations this user participates in,
     * ordered by latest message time.
     */
    public function allConversations()
    {
        return Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->orderByDesc('last_message_at');
    }

    /**
     * Total unread messages across all conversations.
     */
    public function totalUnreadMessages(): int
    {
        return \App\Models\Message::whereHas('conversation', function ($q) {
            $q->where('user_one_id', $this->id)->orWhere('user_two_id', $this->id);
        })->where('sender_id', '!=', $this->id)
          ->where('is_read', false)
          ->count();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'security_pin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'password' => 'hashed',
    ];
}
