<div>
    @if ($logs->isEmpty())
        <p class="text-sm text-zinc-500">No logs yet.</p>
    @else
        <table class="text-sm w-full">
            <thead>
                <tr class="text-left border-b border-zinc-200 dark:border-zinc-700">
                    <th class="pr-4">Status</th>
                    <th class="pr-4">Notes</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr wire:key="activity-log-{{ $log->id }}">
                        <td class="pr-4">
                            {{ $log->completed_at?->format('Y-m-d H:i') ?? $log->status->label() }}
                        </td>
                        <td class="pr-4">{{ $log->notes }}</td>
                        <td class="text-right">
                            @if ($log->isPending())
                                <button wire:click="complete({{ $log->id }})" class="text-green-600 mr-2">Complete</button>
                                <button wire:click="skip({{ $log->id }})" class="text-zinc-500">Skip</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
