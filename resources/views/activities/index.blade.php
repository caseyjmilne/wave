<ul>
    @foreach ($activities as $activity)
        <li>{{ $activity->name }} — {{ $activity->date }}</li>
    @endforeach
</ul>