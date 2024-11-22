@extends('layouts.app')

@section('content')
<h2 class="mb-4">GoToWebinar Information for "{{ $webinar->name }}"</h2>

@if (isset($webinarData))
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Webinar Details</h5>
        <p><strong>GoToWebinar ID:</strong> {{ $webinarData['webinarKey'] }}</p>
        <p><strong>Title:</strong> {{ $webinarData['subject'] }}</p>
        <p><strong>Description:</strong> {{ $webinarData['description'] }}</p>
        <p><strong>Event Start Time:</strong> {{ \Carbon\Carbon::parse($webinarData['startTime'])->format('F j, Y, g:i a') }}</p>
        <!-- Add more fields based on the GoToWebinar API response structure -->
    </div>
</div>
@else
<p>No data found for this webinar.</p>
@endif
@endsection