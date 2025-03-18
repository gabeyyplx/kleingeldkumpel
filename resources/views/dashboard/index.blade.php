@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="box">
        <strong>Account balance:</strong><br>
        {{ number_format($account->balance, 2, ',', '.') }} {{ $account->currency }}
    </div>
    <div class="box">
        <strong>
            Expenses since {{ date_format(now()->startOfMonth(), 'd.m.Y') }} </strong>
        <canvas 
        id="expensesPieChart"
        data-labels="{{ json_encode($expenses->pluck('name')) }}"
        data-values="{{ json_encode($expenses->pluck('total')) }}"
        ></canvas>
        Total: {{ number_format(array_sum($expenses->pluck('total')->toArray()), 2, ',', '.')  }} {{ $account->currency }}
    </div>
@endsection
