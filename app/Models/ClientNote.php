<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'stylist_id',
        'notes',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function stylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
