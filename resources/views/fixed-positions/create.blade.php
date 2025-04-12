@extends('app')

@section('title', 'New Fixed Position')

@section('content')
    @if ($errors->any())
        <div class="box error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('fixed-positions.form', [
        'action' => route('fixed-positions.store'),
        'method' => null,
        'fixed_position' => null,
        'categories' => $categories,
        'buttonText' => 'Save'
    ])
@endsection
