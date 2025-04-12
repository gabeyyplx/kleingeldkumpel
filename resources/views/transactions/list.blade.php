@foreach ($transactions as $transaction)
<a href="{{ route('transactions.edit', $transaction->id) }}">
    <div class="transaction box {{ $transaction->type }}">
        <div class="icon">
            {{$transaction->category->icon}}
        </div>
        <div class="name-date">
            <div class="name">
                {{ $transaction->name }}
            </div>
            <div class="date">
                {{ $formatter->date(date_create($transaction->date), $user) }}
            </div>
        </div>
        <div class="value">
            {{ $transaction->type === 'expense' ? '-' : '' }}{{ $formatter->currency($transaction->value, $account) }}
        </div>
    </div>
</a>
@endforeach