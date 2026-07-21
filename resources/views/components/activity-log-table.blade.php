@if ($logs->isEmpty())
    <p class="text-sm text-zinc-500">No logs yet.</p>
@else
    <table class="text-sm w-full">
        <thead>
            <tr class="text-left border-b border-zinc-200 dark:border-zinc-700">
                <th class="pr-4">Completed</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="pr-4">
                        {{ $log->completed_at?->format('Y-m-d H:i') ?? ucfirst($log->status) }}
                    </td>
                    <td>{{ $log->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif