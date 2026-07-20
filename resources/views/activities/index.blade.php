<x-layouts::app title="Activities">
    <div class="mb-10">
        <a href="{{ route('activities.create') }}" class="border border-zinc-100 px-2 py-1">Create Activity</a>
    </div>
    <x-activity-list :activities="$activities" />
</x-layouts::app>