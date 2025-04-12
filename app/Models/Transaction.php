<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Transaction extends Model
{
    use hasFactory;
    
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
