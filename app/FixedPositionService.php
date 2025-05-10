<?php
namespace App;

use App\Models\FixedPosition;
use App\Models\Transaction;

class FixedPositionService {

    protected Account $account;
    protected array $fixedPositions;

    public function getAccount() {
        return $this->account;
    }

    public function getFixedPositions() {
        return $this->fixedPositions;
    }

    public function setAccount(Account $account) {
        $this->account = $account;
        return $this;        
    }

    public function setFixedPositions(array $fixedPositions) {
        foreach($fixedPositions as $position) {
            if($position instanceof FixedPosition === false) {
                return $this;;
            }
            $this->fixedPositions = $fixedPositions;
            return $this;
        }
    }

    public function process($account) {
        $this->loadPositions();
        foreach($this->getFixedPositions() as $position) {
            if($position->isExpired()) {
                $position->disable();
                continue;
            }
            if($position->isDue()) {
                spawnTransaction($position);
                $position->updateAppliedDate(now());
            }
        }
    }

    public function loadPositions() {
        $positions = FixedPosition::where('account_id', $this->getAccount()->id)->with('category');
        $this->setFixedPositions($positions);
    }

    private function spawnTransaction($position) {
        $account = $this->getAccount();
        $parameters = [
            'category_id' => $position->category->id,
            'account_id' => $account->id,
            'value' => $position->value,
            'type' => $position->value,
            'name' => $position->name,
            'date' => now(),
        ];
        $transaction = Transaction::create($parameters);
        $balanceValue = $transaction->value;
        if($transaction->type === 'expense') {
            $balanceValue *= -1;
        }
        $account->balance += $balanceValue;
        $account->save();
    }
}