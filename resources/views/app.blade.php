<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') | Kleingeldkumpel</title>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="app">  
            <div class="content">
                @yield('content')
            </div>

            <div class="menu box">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('transactions.index') }}">Transactions</a>
            </div>
        </div>
    </body>
</html>
