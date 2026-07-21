<div>
    @if ($logs->isEmpty())
        <p class="text-sm text-zinc-500">No logs yet.</p>
    @else
        <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-700">
            @foreach ($logs as $log)
                <div class="flex items-center justify-between gap-4 py-2" wire:key="activity-log-{{ $log->id }}">
                    <div>
                        <div class="font-medium">{{ $log->title ?? 'Log' }}</div>
                        <div class="text-sm text-zinc-500">
                            @if ($log->completed_at)
                                Completed {{ $log->completed_at->format('M j, Y g:ia') }}
                            @else
                                {{ $log->status->label() }}
                            @endif
                            @if ($log->notes)
                                · {{ $log->notes }}
                            @endif
                        </div>
                    </div>
                    @if ($log->isPending())
                        <div class="flex shrink-0 gap-3 text-sm">
                            <button wire:click="complete({{ $log->id }})" class="text-green-600">Complete</button>
                            <button wire:click="skip({{ $log->id }})" class="text-zinc-500">Skip</button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
