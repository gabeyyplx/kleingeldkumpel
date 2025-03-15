@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="box">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="button remove" type="submit">Logout</button>
        </form>
    </div>
@endsection
