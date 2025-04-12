@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="box">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="button remove" type="submit">Logout</button>
        </form>
        <div class="link-list">
            <a href="{{ route('fixed-positions.index') }}">Manage fixed positions</a>
            <a href="#">Manage accounts (coming soon&trade;)</a>
            <a href="#">Manage users (coming soon&trade;)</a>
            <a href="#">Manage categories (coming soon&trade;)</a>
        </div>
    </div>
@endsection
