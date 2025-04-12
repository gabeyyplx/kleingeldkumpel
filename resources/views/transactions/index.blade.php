@extends('app')

@section('title', 'Transactions')

@section('content')
<div class="box">
    <div class="row">
        <div class="balance">
            <strong>Account balance:</strong><br>
            {{ $formatter->currency($account->balance) }}
        </div>
        <a class="button add" href="{{ route('transactions.create') }}">+ Add Transaction</a>
    </div>
</div>

@if (session('success'))
<div class="box success">{{ session('success') }}</div>
@endif

@include('transactions.list') 
@endsection