<div>
    <button wire:click="$set('confirming', true)" class="text-red-600">Delete</button>
    @if ($confirming)
        <div class="delete-confirm-modal fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                <h2 class="font-semibold text-lg mb-2">Delete activity?</h2>
                <p class="text-gray-600 mb-4">This can't be undone.</p>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('confirming', false)" class="px-4 py-2 rounded border">Cancel</button>
                    <button wire:click="delete" class="px-4 py-2 rounded bg-red-600 text-white">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>