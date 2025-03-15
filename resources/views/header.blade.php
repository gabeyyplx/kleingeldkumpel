<div class="header">
    <div class="title">
        💰 @yield('title')
    </div>
    @if(isset($accounts))
    <div class="accounts">
        <form>
            <select onchange="this.form.submit()" name="account" id="account">
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif
</div>