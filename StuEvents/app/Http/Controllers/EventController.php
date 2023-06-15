<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\UserEventsAttendee;


class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please log in to create an event');
        }

        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required',
        ]);

        $event = Event::create($data);

        if (auth()->check()) {
            $userEventAttendee = UserEventsAttendee::create([
                'user_id' => auth()->user()->id,
                'event_id' => $event->id,
            ]);
        }

        // Redirect
        return redirect()->route('events.show', $event->id)
            ->with('success', 'Event created successfully!');
    }

    public function show($id)
    {
        $event = Event::with('attendees')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function register($id)
    {
        $event = Event::findOrFail($id);
        return view('events.register', compact('event'));
    }

    public function storeAttendee(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $event = Event::findOrFail($id);
        $event->attendees()->create($data);

        return redirect()->route('events.show', $id)->with('success', 'Registered successfully!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required',
        ]);

        $event = Event::findOrFail($id);
        $event->update($data);

        return redirect('/events')->with('success', 'Event updated successfully!');
    }
}
