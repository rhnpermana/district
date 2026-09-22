<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'stylist_id',
        'title',
        'image_path',
        'description',
    ];

    public function stylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
