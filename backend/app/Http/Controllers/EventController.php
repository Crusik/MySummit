<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = $request -> user()
             -> events()
             -> orderBy('start_time')
             -> get();

        return response() -> json($events);
    }

    public function store(Request $request)
    {
        $validated = $request -> validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time'
        ]);

        $event = Event::create($validated);
        return response() -> json($event, 201);
    }
}