@if(Auth::check())
<div class="menu">
    <a href="{{ route('dashboard') }}"><i>📊</i> Dashboard</a>
    <a href="{{ route('transactions.index') }}"><i>📒</i>Transactions</a>
    <a href="{{ route('settings') }}"><i>⚙️</i>Settings</a>
</div>
@endif
