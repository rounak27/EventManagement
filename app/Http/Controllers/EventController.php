<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Hashtag;
use Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
   
    // Get selected filter from request, default to 'all'
    $selectedFilter = $request->input('filter', 'all');

    // Retrieve all events from the database with eager loaded hashtags
    $eventsQuery = Event::with('hashtags');

    // Apply filter based on the selected option
    switch ($selectedFilter) {
        case 'finished':
            $eventsQuery->where('end_date', '<', now());
            break;
        case 'upcoming':
            $eventsQuery->where('start_date', '>', now());
            break;
        case 'within_7_days':
            $eventsQuery->whereBetween('start_date', [now(), now()->addDays(7)]);
            break;
        case 'all':
        default:
            
            break;
    }

    // Get the filtered events
    $events = $eventsQuery->orderBy('start_date')->get();

    return view('events.display', compact('events', 'selectedFilter', 'user'));
}

    public function create()
    {
        return view('events.create');
    }
    public function store(Request $request)
    {
       // $csrfToken = request()->session()->token();
        //$request->session()->regenerateToken();
        //dd($csrfToken);
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'hashtags' => 'nullable|string',
        ]);

        // Create a new event
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;

        // Associate the event with the current logged-in user
        $event->user_id = auth()->id();

        // Save the event
        $event->save();
        if ($request->has('hashtags')) {
            $hashtags = explode(',', $request->input('hashtags'));
            foreach ($hashtags as $hashtag) {
                $trimmedHashtag = trim($hashtag);
                if ($trimmedHashtag !== '') {
                    $newHashtag = new Hashtag(['name' => $trimmedHashtag]);
                    $event->hashtags()->save($newHashtag);
                }
            }
        }
        // Redirect back with a success message
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }
    public function edit(Event $event)
    {
        // Check if the authenticated user is the owner of the event
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.edit', compact('event'));
    }
    public function update(Request $request, Event $event)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Update the event
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Redirect back with a success message
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }
    public function destroy(Event $event)
    {
    // Check if the authenticated user is the owner of the event
    if ($event->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Delete the event
    $event->delete();

    return response()->json(['message' => 'Event deleted successfully.']);
    }
    public function searchByTitle(Request $request)
    {
        $query = $request->input('q');
       
        
        $events = Event::where('title', 'like', "%$query%")->orderBy('start_date')->get();
        return view('events.search_result', compact('events', 'query'));
    }
}
