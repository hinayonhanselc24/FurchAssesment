@extends('layouts.app')

@section('content')
<h2 class="mb-4">Edit Webinar</h2>
<form action="{{ route('webinars.update', $webinar->id) }}" method="POST" class="border p-4 rounded shadow">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Webinar Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $webinar->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $webinar->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="event" class="form-label">Event Date & Time</label>
        <input type="datetime-local" name="event" id="event" class="form-control"
            value="{{ old('event', $webinar->event ? date('Y-m-d\TH:i', strtotime($webinar->event)) : '') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Webinar</button>
</form>
@endsection