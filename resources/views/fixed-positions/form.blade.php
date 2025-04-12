<div class="box">
    <form action="{{ $action }}" method="POST">
        @csrf
        @isset($method)
        @method($method)
        @endisset
        <div class="form-group">
            <label for="value">Amount</label>
            <input type="number" name="value" id="value" step="0.01" value="{{ old('value', $position->value ?? '')  }}">
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $position->name ?? '') }}">
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type">
                <option value="expense" @if(old('type', $position->type ?? '') === 'expense') selected @endif>Expense</option>
                <option value="income" @if(old('type', $position->type ?? '') === 'income') selected @endif>Income</option>
            </select>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @if(old('category_id', $position->category_id ?? '') === $category->id)
                    selected
                    @endif
                    >
                    {{$category->icon}} {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="period">Period</label>
            <select name="period" id="period">
                @foreach ($periods as $period)
                <option
                    value="{{ $period }}"
                    @if(old('category_id', $position->period ?? '') === $period)
                    selected
                    @endif
                    >
                    {{$period}}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Start date</label>
            <input type="date" name="start_date" id="start_date" value="{{ (old('start_date', $position->start_date ?? date('Y-m-d'))) }}">
        </div>
        <div class="form-group">
            <label for="date">End date</label>
            <input type="date" name="end_date" id="end_date" value="{{ (old('end_date', $position->end_date ?? '')) }}">
        </div>
        <div class="form-group">
            <input type="checkbox" name="active" id="active" 
                @if(isset($position))
                    {{ $position->active === 1 ? 'checked' : ''}}
                @else
                    checked
                @endif
                value="1"> Active
        </div>
        <input type="hidden" name="account_id" value="{{ $account->id }}">
        <button class="button add" type="submit">{{ $buttonText }}</button>
    </form>
    @if (request()->routeIs('fixed-positions.edit'))
    <form action="{{ route('fixed-positions.destroy', $position->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this position?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="button remove">
            Delete
        </button>
    </form>
    @endif
</div>