<div>
    @if ($logs->isEmpty())
        <p class="text-sm text-zinc-500">No logs yet.</p>
    @else
        <div class="grid grid-cols-[minmax(0,1.5fr)_auto_minmax(0,1.5fr)_auto] items-center gap-x-4 gap-y-1 text-sm">
            <div class="contents text-zinc-500">
                <div class="border-b border-zinc-200 pb-1 dark:border-zinc-700">Log</div>
                <div class="border-b border-zinc-200 pb-1 dark:border-zinc-700">Status</div>
                <div class="border-b border-zinc-200 pb-1 dark:border-zinc-700">Notes</div>
                <div class="border-b border-zinc-200 pb-1 dark:border-zinc-700"></div>
            </div>

            @foreach ($logs as $log)
                <div class="contents" wire:key="activity-log-{{ $log->id }}">
                    <div class="py-1">{{ $log->title ?? 'Log' }}</div>
                    <div class="py-1">
                        {{ $log->completed_at?->format('Y-m-d H:i') ?? $log->status->label() }}
                    </div>
                    <div class="py-1 text-zinc-500">{{ $log->notes }}</div>
                    <div class="py-1 text-right">
                        @if ($log->isPending())
                            <button wire:click="complete({{ $log->id }})" class="mr-2 text-green-600">Complete</button>
                            <button wire:click="skip({{ $log->id }})" class="text-zinc-500">Skip</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
