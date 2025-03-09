<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon'
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
