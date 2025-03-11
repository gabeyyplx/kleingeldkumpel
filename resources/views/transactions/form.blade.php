<div class="box">
    <form action="{{ $action }}" method="POST">
        @csrf
        @isset($method)
            @method($method)
        @endisset
         <div class="form-group">
            <label for="value">Amount</label>
            <input type="number" name="value" id="value" step="0.01" value="{{ old('value', $transaction->value ?? '')  }}">
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $transaction->name ?? '') }}">
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option 
                        value="{{ $category->id }}"
                        @if(old('category_id', $transaction->category_id ?? '')  === $category->id) 
                            selected 
                        @endif
                    >
                        {{$category->icon}} {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="{{ (old('date', $transaction->date ?? date('Y-m-d'))) }}">
        </div>
        <input type="hidden" name="account_id" value="{{ $account->id }}">
        <button class="button add" type="submit">{{ $buttonText }}</button>
    </form>
    @if (request()->routeIs('transactions.edit'))
            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="button remove">
                    Delete
                </button>
            </form>
    @endif
</div>