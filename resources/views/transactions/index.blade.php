@extends('app')

@section('title', 'Transactions')

@section('content')
    <h1>Transactions</h1>
    <h2>Account balance: {{ number_format($account->balance, 2, ',', '.') }} €</h2>
    <a href="{{ route('transactions.create') }}">+ Add Transaction</a>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @foreach ($transactions as $transaction)
                <div class="transaction">
                    <div class="name">
                        {{$transaction->category->icon}} {{ $transaction->name }}
                    </div>
                    <div class="date">
                        {{ $transaction->date }}
                    </div>
                    <div class="amount">
                        {{ number_format($transaction->value, 2, ',', '.') }} €
                    </div>
                </div>
    @endforeach          
@endsection
