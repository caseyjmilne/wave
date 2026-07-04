<x-layouts::app title="Activities">
    <ul>
        @foreach ($activities as $activity)
            <li class="flex gap-6 space-between">
                <div>
                    {{ $activity->name }} — {{ $activity->date }}
                </div>
                <livewire:activities.delete-button :activity="$activity" />
            </li>
        @endforeach
    </ul>
</x-layouts::app>