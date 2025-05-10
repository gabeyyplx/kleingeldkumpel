<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function isDue() {
        if($this->period === null) {
            return false;
        }
        if($this->active === false) {
            return false;
        }
        $today = Carbon::now();
        $startDate = new Carbon($this->start_date);
        if($this->last_applied === null) {
            return $today->isGreaterOrEqualThan($startDate);
        }
        $lastAppliedDate = new Carbon($this->last_applied);
        $dueDate = $lastAppliedDate->addMonths(
            $this->period->inMonths()
        );
        return $today->isGreaterOrEqualThan($dueDate);
    }

    public function isExpired() {
        if($this->end_date === null) {
            return false;
        }
        $today = Carbon::now();
        $endDate = new Carbon($this->end_date);
        if($today->lessThan($endDate)) {
            return false;
        }
        return true;
    }

    public function disable() {
        $this->active = false;
        $this->save();
    }

    public function updateAppliedDate(Carbon $date = null) {
        if($date === null) {
            $date = now();
        }
        $this->last_applied = $date;
        $this->save();
    }
}
