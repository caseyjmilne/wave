<div class="flex flex-col gap-4">
    <x-form-field>
        <label>Type</label>
        <select wire:model.live="type" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
            <option value="singular">Single event</option>
            <option value="recurring">Recurring</option>
        </select>
    </x-form-field>

    @if ($type === 'singular')
        <x-form-field>
            <label>Date</label>
            <input type="date" wire:model="date" name="date" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
        </x-form-field>
    @else
        <x-form-field>
            <label>Frequency</label>
            <select wire:model="frequency" name="frequency" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="yearly">Yearly</option>
            </select>
        </x-form-field>

        <x-form-field>
            <label>Times per period</label>
            <input type="number" wire:model="times_per_period" name="times_per_period" min="1" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
        </x-form-field>
    @endif

    <input type="hidden" name="type" value="{{ $type }}">
</div>