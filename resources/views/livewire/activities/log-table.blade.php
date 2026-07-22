<div>
    @if ($logs->isEmpty())
        <p class="text-sm text-zinc-500">No logs yet.</p>
    @else
        <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-700">
            @foreach ($logs as $log)
                <div
                    class="flex items-center gap-3 rounded px-2 py-2 text-sm {{ $log->isCompleted() ? 'bg-green-50 dark:bg-green-950/30' : ($log->isSkipped() ? 'bg-amber-50 dark:bg-amber-950/20' : '') }}"
                    wire:key="activity-log-{{ $log->id }}"
                >
                    <div class="flex w-40 shrink-0 gap-2 text-xs">
                        <button
                            wire:click="complete({{ $log->id }})"
                            class="flex w-1/2 items-center justify-center gap-1 rounded px-2 py-1 font-medium {{ $log->isCompleted() ? 'bg-green-600 text-white' : 'border border-zinc-300 text-green-600 hover:bg-green-50 dark:border-zinc-700 dark:hover:bg-zinc-800' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check h-3.5 w-3.5 shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                            Complete
                        </button>
                        <button
                            wire:click="skip({{ $log->id }})"
                            class="flex w-1/2 items-center justify-center gap-1 rounded px-2 py-1 font-medium {{ $log->isSkipped() ? 'bg-amber-600 text-white' : 'border border-zinc-300 text-zinc-500 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-skip-forward-icon lucide-skip-forward h-3.5 w-3.5 shrink-0"><path d="M21 4v16"/><path d="M6.029 4.285A2 2 0 0 0 3 6v12a2 2 0 0 0 3.029 1.715l9.997-5.998a2 2 0 0 0 .003-3.432z"/></svg>
                            Skip
                        </button>
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

    @if ($confirmingLogId)
        @php($confirmingLog = $logs->firstWhere('id', $confirmingLogId))
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="w-full max-w-sm rounded-lg bg-white p-6 dark:bg-zinc-800">
                @if ($confirmingTargetStatus === 'skipped')
                    <h2 class="mb-2 text-lg font-semibold">Mark as skipped?</h2>
                    <p class="mb-4 text-zinc-600 dark:text-zinc-400">This undoes the completion for "{{ $confirmingLog?->title }}".</p>
                @else
                    <h2 class="mb-2 text-lg font-semibold">Undo {{ $confirmingLog?->status->label() }}?</h2>
                    <p class="mb-4 text-zinc-600 dark:text-zinc-400">This sets "{{ $confirmingLog?->title }}" back to pending.</p>
                @endif
                <div class="flex justify-end gap-2">
                    <button wire:click="cancelChange" class="rounded border px-4 py-2">Cancel</button>
                    <button wire:click="confirmChange" class="rounded bg-zinc-800 px-4 py-2 text-white dark:bg-zinc-200 dark:text-zinc-900">Yes, continue</button>
                </div>
            </div>
        </div>
    @endif
</div>
