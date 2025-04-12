@foreach ($fixed_positions as $position)
<a href="{{ route('fixed-positions.edit', $position->id) }}">
    <div class="transaction box {{ $position->type }}">
        <div class="icon">
            {{$position->category->icon}}
        </div>
        <div class="name-date">
            <div class="name">
                {{ $position->name }}
            </div>
            <div class="date">
                {{ $formatter->date(date_create($position->start_date), $user) }}
                @if($position->end_date)
                - {{ $formatter->date(date_create($position->end_date), $user) }}
                @endif
                <br />
                Last applied: {{ $position->last_applied ? $formatter->date(date_create($position->last_applied)) : '-'}}
            </div>
        </div>
        <div class="value">
            {{ $position->type === 'expense' ? '-' : '' }}{{ $formatter->currency($position->value, $account) }}
        </div>
    </div>
</a>
@endforeach