<h2 class="text-3xl mb-4">Activities</h2>
<ul>
    @foreach ($activities as $activity)
        <li class="flex flex-col gap-2 mb-6">
            <div class="flex items-center gap-4">
                <livewire:activities.actions-menu :activity="$activity" :key="'actions-menu-'.$activity->id" />
                <div class="flex flex-1 items-start justify-between gap-4">
                    <div>
                        <div class="font-medium">{{ $activity->name }}</div>
                        @if ($activity->schedule)
                            <div class="text-sm text-zinc-500">{{ ucfirst($activity->schedule->frequency) }} · {{ $activity->schedule->times_per_period }}x</div>
                        @elseif ($activity->date)
                            <div class="text-sm text-zinc-500">{{ $activity->date->format('M j, Y') }}</div>
                        @endif
                    </div>
                    @if ($activity->schedule)
                        <span class="whitespace-nowrap text-sm text-zinc-500">🔥 {{ $activity->streak }}</span>
                    @endif
                </div>
            </div>
            <livewire:activities.log-table :activity="$activity" :key="'log-table-'.$activity->id" />
        </li>
    @endforeach
</ul>