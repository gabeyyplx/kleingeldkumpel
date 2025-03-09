<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',
        'balance',
        'user_id',
    ];
    
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function fixedPositions() {
        return $this->hasMany(FixedPosition::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

