@extends('layouts.app')

@section('content')
<h2 class="mb-4">Create Webinar</h2>
<form action="{{ route('webinars.store') }}" method="POST" class="border p-4 rounded shadow">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Webinar Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="event" class="form-label">Event Date & Time</label>
        <input type="datetime-local" name="event" id="event" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>
@endsection