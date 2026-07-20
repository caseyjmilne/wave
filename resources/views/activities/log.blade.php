<x-layouts::app title="Log Activity">
    <h2 class="text-2xl mb-4">{{ $activity->name }} (#{{ $activity->id }})</h2>
    <form method="POST" action="{{ route('activities.log.store', $activity->id) }}" class="flex flex-col gap-4">
        @csrf

        <x-form-field>
            <label>Completed at</label>
            <input type="datetime-local" name="completed_at" value="{{ old('completed_at', now()->format('Y-m-d\TH:i')) }}" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
        </x-form-field>

        <x-form-field>
            <label>Notes</label>
            <textarea name="notes" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">{{ old('notes') }}</textarea>
        </x-form-field>

        <button type="submit" class="bg-zinc-800 dark:bg-zinc-200 dark:text-zinc-900 text-white rounded-md px-4 py-2">Save</button>
    </form>
</x-layouts::app>