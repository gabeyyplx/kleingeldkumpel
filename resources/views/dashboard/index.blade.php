@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="box">
        <strong>Account balance:</strong><br>
        {{ $CurrencyFormatter::format($account->balance, $account) }}
    </div>

    @if($expenses->pluck('total')->sum() !== 0)
    <div class="box">
        <strong>
            Expenses since {{ $DateFormatter::format(now()->startOfMonth(), $user) }} </strong>
        <canvas 
        id="expensesPieChart"
        data-labels="{{ json_encode($expenses->pluck('name')) }}"
        data-values="{{ json_encode($expenses->pluck('total')) }}"
        ></canvas>
        Total expenses: {{ $CurrencyFormatter::format(abs($expenses->pluck('total')->sum()), $account) }}
    </div>
    @endif

@endsection
