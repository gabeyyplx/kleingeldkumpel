<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
            'name',
            'value',
            'type',
            'category_id',
            'account_id',
            'date',
    ];
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function account() {
        return $this->belongsTo(Account::class);
    }
}
