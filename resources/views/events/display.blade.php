<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Event List</h1>
    <h2>Hello, {{ $user->name }}</h2> 
    <form method="POST" action="{{ route('logout') }}">
        @csrf
    <div class="col-md-12 text-right">
        <input type="submit" class="btn btn-danger" value="Logout">
    </div>
    </form>
    <a href="{{ route('events.create') }}" class="btn btn-success">Create New Event</a>

    <div class="mt-3">
        <form method="GET" action="{{ route('events.index') }}">
            @csrf
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="finished" value="finished" {{ $selectedFilter === 'finished' ? 'checked' : '' }}>
                <label class="form-check-label" for="finished">
                    Finished Events
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="upcoming" value="upcoming" {{ $selectedFilter === 'upcoming' ? 'checked' : '' }}>
                <label class="form-check-label" for="upcoming">
                    Upcoming Events
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="within_7_days" value="within_7_days"{{ $selectedFilter === 'within_7_days' ? 'checked' : '' }}>
                <label class="form-check-label" for="within_7_days">
                    Events Within 7 Days
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="all" value="all" {{ $selectedFilter === 'all' ? 'checked' : '' }}>
                <label class="form-check-label" for="all">
                    All Events
                </label>
            </div>
        </form>  
    </div>
    <table class="table mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->description }} 
                    @foreach($event->hashtags as $hashtag)
                    <span class="badge badge-secondary">{{ $hashtag->name }}</span>
                    @endforeach
                </td>
                <td>{{ $event->start_date }}</td>
                <td>{{ $event->end_date }}</td>
                <td>
                    @if($event->user_id === auth()->id())
                    <a href="{{route('events.edit',$event->id)}}" class="btn btn-primary">Edit</a>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <button class="btn btn-danger delete-event" data-event-id="{{ $event->id }}">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">
    <form id="searchForm" method="GET">
    <input type="text" id="searchQuery" name="q" placeholder="Search by title">
    <button type="submit">Search</button>
</form></div>

<div id="searchResults"  ></div>

<!-- JavaScript for AJAX Delete ,AND Search-->
<script>
    // jQuery document ready function
    $(document).ready(function() {
        // Click event handler for delete button
        $('.delete-event').click(function(e) {
            e.preventDefault(); // Prevent default button behavior
            
            // Retrieve the event ID from the data attribute
            var eventId = $(this).data('event-id');

            // Confirm deletion with user
            if (confirm('Are you sure you want to delete this event?')) {
                // Send AJAX request to delete the event
                $.ajax({
                    url: '/events/' + eventId, // URL of the delete route
                    type: 'DELETE', // HTTP method
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token from meta tag
                    },
                    success: function(response) {
                        
                        console.log(response.message);
                        window.location.reload(); 
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $('input[type=radio][name=filter]').change(function() {
            
            $('form').submit();
        });
        //search
        $('#searchForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        
        var searchQuery = $('#searchQuery').val(); // Get search query from input
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("events.search") }}',
            method: 'GET',
            data: { q: searchQuery },
            success: function(response) {
                // Handle successful response
                console.log(response);

                $('#searchResults').html(response); // Update search results in DOM
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    });
    });
</script>
</body>
</html>
