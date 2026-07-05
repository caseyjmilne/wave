<x-layouts::app title="Activities">
    <a href="{{ route('activities.create') }}">Create Activity</a>

    <ul>
        @foreach ($activities as $activity)
            <li class="flex gap-6 space-between">
                <div>
                    {{ $activity->name }} — {{ $activity->date }}
                </div>
                <a href="{{ route('activities.edit', $activity->id) }}">Edit</a>
                <livewire:activities.delete-button :activity="$activity" />
            </li>
        @endforeach
    </ul>
</x-layouts::app>