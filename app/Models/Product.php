<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'min_stock',
        'description',
        'image',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/')) {
                return $this->image;
            }
            return asset($this->image);
        }
        return asset('assets/img/hairpowder.webp');
    }
}

