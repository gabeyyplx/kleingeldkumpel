@extends('app')

@section('title', 'Edit fixed position')

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
        'action' => route('fixed-positions.update', $position),
        'method' => 'PUT',
        'position' => $position,
        'categories' => $categories,
        'account' => $account,
        'buttonText' => 'Update'
    ])
@endsection
