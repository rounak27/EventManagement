<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Edit Event</h1>
    <form method="POST" action="{{ route('events.update', $event->id) }}">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}">
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ $event->description }}</textarea>
        </div>

        <!-- Start Date -->
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date }}">
        </div>

        <!-- End Date -->
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date }}">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
</body>
</html>
