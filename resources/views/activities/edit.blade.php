<x-layouts::app title="Edit Activity">
    <form method="POST" action="{{ route('activities.update', $activity->id) }}" class="flex flex-col gap-4 max-w-lg">
        @csrf
        @method('PUT')

        <x-form-field>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $activity->name) }}" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
        </x-form-field>

        <x-form-field>
            <label>Description</label>
            <textarea name="description" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">{{ old('description', $activity->description) }}</textarea>
        </x-form-field>

        <livewire:activities.schedule-fields :activity="$activity" />

        <button type="submit" class="bg-zinc-800 dark:bg-zinc-200 dark:text-zinc-900 text-white rounded-md px-4 py-2">Save</button>
    </form>

    <div class="mt-12">
        <a href="{{ route('activities.index') }}" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">Cancel</a>
    </div>
</x-layouts::app>