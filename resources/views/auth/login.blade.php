@extends('app')

@section('title', 'Login')

@section('content')
<div class="box">
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button class="button" type="submit">Login</button>
    </form>
</div>
@endsection

