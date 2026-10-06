<div>
    <h1>Залы</h1>

    @forelse ($halls as $hall)
        <div>
            <h2>{{ $hall->name }}</h2>

            @if ($hall->description)
                <p>{{ $hall->description }}</p>
            @endif
        </div>
    @empty
        <p>Залов пока нет.</p>
    @endforelse
</div>
