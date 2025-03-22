@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="box">
        <strong>Account balance:</strong><br>
        {{ $formatter->currency($account->balance) }}
    </div>

    @if($expenses->pluck('total')->sum() !== 0)
    <div class="box">
        <strong>
            Expenses since {{ $formatter->date(now()->startOfMonth()) }} </strong>
        <canvas 
        id="expensesPieChart"
        data-labels="{{ json_encode($expenses->pluck('name')) }}"
        data-values="{{ json_encode($expenses->pluck('total')) }}"
        ></canvas>
        Total expenses: {{ $formatter->currency($expenses->pluck('total')->sum()) }}
    </div>
    @endif

@endsection
