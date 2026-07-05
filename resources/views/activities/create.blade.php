<x-layouts::app title="Create Activity">
    <form method="POST" action="{{ route('activities.store') }}" class="flex flex-col gap-4">
        @csrf

        <x-form-field>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">
        </x-form-field>

        <x-form-field>
            <label>Description</label>
            <textarea name="description" class="border border-zinc-200 dark:border-zinc-700 rounded-md px-3 py-2">{{ old('description') }}</textarea>
        </x-form-field>

        <livewire:activities.schedule-fields />

        <button type="submit" class="bg-zinc-800 dark:bg-zinc-200 dark:text-zinc-900 text-white rounded-md px-4 py-2">Save</button>
    </form>

    @if ($errors->any())
        <ul class="text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</x-layouts::app>