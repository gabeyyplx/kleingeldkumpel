@extends('app')

@section('title', 'Transactions')

@section('content')
    <h1>Transactions</h1>
    <div class="box">
        <div class="row">
            <div class="balance">Account balance: {{ number_format($account->balance, 2, ',', '.') }} €</div>
            <a class="button add" href="{{ route('transactions.create') }}">+ Add Transaction</a>
        </div>
        </div>

    @if (session('success'))
        <div class="box success">{{ session('success') }}</div>
    @endif

    @foreach ($transactions as $transaction)
                <div class="transaction box">
                    <div class="icon">
                        {{$transaction->category->icon}} 
                    </div>
                    <div class="name-date">
                        <div class="name">
                            {{ $transaction->name }}
                        </div>
                        <div class="date">
                            {{ date_format(date_create($transaction->date), 'd.m.Y') }}
                        </div>
                    </div>
                    <div class="amount">
                        {{ number_format($transaction->value, 2, ',', '.') }} €
                    </div>
                </div>
    @endforeach          
@endsection
