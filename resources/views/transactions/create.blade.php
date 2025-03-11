@extends('app')

@section('title', 'New Transaction')

@section('content')
    <h1>New Transaction</h1>
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
        'action' => route('transactions.store'),
        'method' => null,
        'transaction' => null,
        'categories' => $categories,
        'buttonText' => 'Save'
    ])
@endsection
