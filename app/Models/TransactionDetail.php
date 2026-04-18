<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'name',
        'price',
        'qty',
        'subtotal',
        'category',
        'status',
        'cooking_started_at',
        'cooking_finished_at',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getStartTimeAttribute()
    {
        return $this->cooking_started_at
            ? $this->cooking_started_at->format('H:i:s')
            : null;
    }
}
