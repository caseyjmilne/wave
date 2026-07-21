<div class="relative">
    <button wire:click="toggle" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300" aria-label="Activity actions">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-icon lucide-grip"><circle cx="12" cy="5" r="1"/><circle cx="19" cy="5" r="1"/><circle cx="5" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/><circle cx="12" cy="19" r="1"/><circle cx="19" cy="19" r="1"/><circle cx="5" cy="19" r="1"/></svg>
    </button>

    @if ($open)
        <div class="absolute left-0 top-full mt-1 z-10 w-32 rounded border border-zinc-200 bg-white text-sm shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
            <a href="{{ route('activities.edit', $activity->id) }}" class="block px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700">Edit</a>
            <button wire:click="$set('confirmingDelete', true)" class="block w-full px-4 py-2 text-left text-red-600 hover:bg-zinc-100 dark:hover:bg-zinc-700">Delete</button>
        </div>
    @endif

    @if ($confirmingDelete)
        <div class="delete-confirm-modal fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="w-full max-w-sm rounded-lg bg-white p-6">
                <h2 class="mb-2 text-lg font-semibold">Delete activity?</h2>
                <p class="mb-4 text-gray-600">This can't be undone.</p>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('confirmingDelete', false)" class="rounded border px-4 py-2">Cancel</button>
                    <button wire:click="delete" class="rounded bg-red-600 px-4 py-2 text-white">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
