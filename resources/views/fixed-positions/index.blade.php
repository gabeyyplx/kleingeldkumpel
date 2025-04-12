@extends('app')

@section('title', 'Fixed positions')

@section('content')
<div class="box">
    <div class="row">
        <a class="button add" href="{{ route('fixed-positions.create') }}">+ Add fixed position</a>
    </div>
</div>

@if (session('success'))
<div class="box success">{{ session('success') }}</div>
@endif

<div class="fixed-positions-list infinite-scrolling">
@include('fixed-positions.list') 
</div>

@endsection