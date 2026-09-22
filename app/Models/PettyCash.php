<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;

    protected $table = 'petty_cashes';

    protected $fillable = [
        'cashier_id',
        'amount',
        'category',
        'description',
        'expense_date',
    ];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
