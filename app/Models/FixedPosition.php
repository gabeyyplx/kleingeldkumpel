<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedPosition extends Model
{
    protected $fillable = [
            'name',
            'value',
            'type',
            'active',
            'category_id',
            'account_id',
            'period',
            'start_date',
            'end_date',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }
}
