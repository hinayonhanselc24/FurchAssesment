@extends('layouts.app')

@section('content')
<h2 class="mb-4">Webinars</h2>
<a href="{{ route('webinars.create') }}" class="btn btn-primary mb-3">Create Webinar</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Event Date & Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($webinars as $webinar)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $webinar->name }}</td>
            <td>{{ $webinar->description }}</td>
            <td>{{ date('F j, Y, g:i a', strtotime($webinar->event)) }}</td> <!-- Display the event -->
            <td>
                <a href="{{ route('webinars.edit', $webinar->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('webinars.destroy', $webinar->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this webinar?')">Delete</button>
                </form>

                @if (!$webinar->goto_webinar_id) <!-- Check if webinar is not synced with GoToWebinar -->
                <a href="{{ route('webinars.create_goto_webinar', $webinar->id) }}" class="btn btn-sm btn-primary">Create in GoToWebinar</a>
                @else
                <span class="badge bg-success">Synced</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection