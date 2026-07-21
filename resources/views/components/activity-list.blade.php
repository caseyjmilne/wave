<h2 class="text-3xl mb-4">Activities</h2>
<ul>
    @foreach ($activities as $activity)
        <li class="flex flex-col gap-2 mb-6">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4">
                    <livewire:activities.actions-menu :activity="$activity" :key="'actions-menu-'.$activity->id" />
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
                </div>
                <a href="{{ route('activities.log.create', $activity->id) }}">Log</a>
            </div>
            <livewire:activities.log-table :activity="$activity" :key="'log-table-'.$activity->id" />
        </li>
    @endforeach
</ul>