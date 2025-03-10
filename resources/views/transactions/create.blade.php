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

    <form class="box" action="{{ route('transactions.store') }}" method="POST">
        @csrf
         <div class="form-group">
            <label for="value">Amount</label>
            <input type="number" name="value" id="value" step="0.01" value="">
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="">
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{$category->icon}} {{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}">
        </div>
        <input type="hidden" name="account_id" value="{{ $account->id }}">
        <button class="button add" type="submit">Save</button>
    </form>
@endsection
