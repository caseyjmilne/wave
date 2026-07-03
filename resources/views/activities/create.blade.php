<form method="POST" action="{{ route('activities.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
    <textarea name="description" placeholder="Description">{{ old('description') }}</textarea>
    <input type="date" name="date" value="{{ old('date') }}">
    <button type="submit">Save</button>
</form>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif