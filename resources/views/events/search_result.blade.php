@if ($events->count() > 0)
    <h2>Search Results for "{{ $query }}"</h2>
  
            @foreach($events as $event)
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="border p-4 bg-light">
                            <h1 class="text-center">{{$event->title}}</h1>
                            <!-- Display search result -->
                            <div id="searchResult" class="mt-4">
                                <!-- Search results will be dynamically populated here -->
                                {{$event->description}}
                            </div>
                            <div class="mt-4">
                                <span class="badge badge-secondary">Start Date: {{$event->start_date}}</span>
                                <span class="badge badge-secondary">End Date: {{$event->end_date}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        
@else
    <p>No events found for "{{ $query }}".</p>
@endif
