<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
        protected $fillable = [
        'invoice',
        'table_id',
        'user_id',
        'total',
    ];
    
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
