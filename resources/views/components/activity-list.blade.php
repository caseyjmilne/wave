<h2 class="text-3xl mb-4">Activities</h2>
<ul>
    @foreach ($activities as $activity)
        <li class="flex flex-col gap-2 mb-6">
            <div class="flex gap-6">
                <div>
                    {{ $activity->name }} —
                    @if ($activity->schedule)
                        {{ ucfirst($activity->schedule->frequency) }} ({{ $activity->schedule->times_per_period }}x)
                    @else
                        {{ $activity->date }}
                    @endif
                    @if ($activity->streak)
                        <span class="text-sm text-zinc-500"> {{ $activity->streak }} 🔥</span>
                    @else
                        --🔥
                    @endif
                </div>
                <a href="{{ route('activities.log.create', $activity->id) }}">Log</a>
                <a href="{{ route('activities.edit', $activity->id) }}">Edit</a>
                <livewire:activities.delete-button :activity="$activity" />
            </div>
            <livewire:activities.log-table :activity="$activity" :key="'log-table-'.$activity->id" />
        </li>
    @endforeach
</ul>