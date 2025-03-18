<div class="header">
    <div class="title">
        💰 @yield('title')
    </div>
    @if(isset($accounts))
    <div class="accounts">
        <form method="POST" action="{{ route('user.updateCurrentAccount') }}">
            @csrf
            <select onchange="this.form.submit()" name="current_account" id="account">
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" @if($user->current_account === $account->id) selected @endif>{{ $account->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif
</div>