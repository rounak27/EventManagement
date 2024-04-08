<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Event</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Create New Event</h1>
    <form id="createEventForm" method="POST" action="{{ route('events.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter event title">
            <div class="text-danger" id="titleError"></div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter event description"></textarea>
            <div class="text-danger" id="descriptionError"></div>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" class="form-control" id="start_date" name="start_date">
            <div class="text-danger" id="startDateError"></div>
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="datetime-local" class="form-control" id="end_date" name="end_date">
            <div class="text-danger" id="endDateError"></div>
        </div>
        <div class="form-group">
            <label for="hashtags">Hashtags (separate by ',')</label>
            <input type="text" class="form-control" id="hashtags" name="hashtags" placeholder="Enter hashtags">
        </div>
        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
</div>

<script>
    document.getElementById('createEventForm').addEventListener('submit', function (event) {
        var title = document.getElementById('title').value.trim();
        var description = document.getElementById('description').value.trim();
        var startDate = document.getElementById('start_date').value.trim();
        var endDate = document.getElementById('end_date').value.trim();
        var titleError = document.getElementById('titleError');
        var descriptionError = document.getElementById('descriptionError');
        var startDateError = document.getElementById('startDateError');
        var endDateError = document.getElementById('endDateError');
        var isValid = true;

        if (!title) {
            titleError.innerHTML = 'Title is required';
            isValid = false;
        } else {
            titleError.innerHTML = '';
        }

        if (!description) {
            descriptionError.innerHTML = 'Description is required';
            isValid = false;
        } else {
            descriptionError.innerHTML = '';
        }

        if (!startDate) {
            startDateError.innerHTML = 'Start Date is required';
            isValid = false;
        } else {
            startDateError.innerHTML = '';
        }

        if (!endDate) {
            endDateError.innerHTML = 'End Date is required';
            isValid = false;
        } else {
            endDateError.innerHTML = '';
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>
