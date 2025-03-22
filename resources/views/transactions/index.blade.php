@extends('app')

@section('title', 'Transactions')

@section('content')
    <div class="box">
        <div class="row">
            <div class="balance">
                <strong>Account balance:</strong><br> 
                {{ $formatter->formatCurrency($account->balance, $account) }}
            </div>
            <a class="button add" href="{{ route('transactions.create') }}">+ Add Transaction</a>
            </div>
        </div>

    @if (session('success'))
        <div class="box success">{{ session('success') }}</div>
    @endif

    @foreach ($transactions as $transaction)
            <a href="{{ route('transactions.edit', $transaction->id) }}">
                <div class="transaction box">
                    <div class="icon">
                        {{$transaction->category->icon}} 
                    </div>
                    <div class="name-date">
                        <div class="name">
                            {{ $transaction->name }}
                        </div>
                        <div class="date">
                            {{ $formatter->formatDate(date_create($transaction->date), $user) }}
                        </div>
                    </div>
                    <div class="amount">
                        {{ $formatter->formatCurrency($transaction->value, $account) }}
                    </div>
                </div>
            </a>
    @endforeach          
@endsection
