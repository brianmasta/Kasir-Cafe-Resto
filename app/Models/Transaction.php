<?php

namespace App\Models;

use App\Models\User;

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

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
