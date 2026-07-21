<div>
    @if ($logs->isEmpty())
        <p class="text-sm text-zinc-500">No logs yet.</p>
    @else
        <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-700">
            @foreach ($logs as $log)
                <div class="flex items-center gap-3 py-2 text-sm" wire:key="activity-log-{{ $log->id }}">
                    <div class="flex w-28 shrink-0 gap-2">
                        @if ($log->isPending())
                            <button wire:click="complete({{ $log->id }})" class="text-green-600">Complete</button>
                            <button wire:click="skip({{ $log->id }})" class="text-zinc-500">Skip</button>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 truncate">
                        <span class="text-sm font-medium">{{ $log->title ?? 'Log' }}</span>
                        <span class="text-zinc-500">
                            ·
                            @if ($log->completed_at)
                                Completed {{ $log->completed_at->format('M j, Y g:ia') }}
                            @else
                                {{ $log->status->label() }}
                            @endif
                            @if ($log->notes)
                                · {{ $log->notes }}
                            @endif
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
