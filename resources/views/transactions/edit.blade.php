@extends('app')

@section('title', 'New Transaction')

@section('content')
    <h1>Edit Transaction</h1>
    @if ($errors->any())
        <div class="box error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('transactions.form', [
        'action' => route('transactions.update', $transaction),
        'method' => 'PUT',
        'transaction' => $transaction,
        'categories' => $categories,
        'account' => $account,
        'buttonText' => 'Update'
    ])
@endsection
