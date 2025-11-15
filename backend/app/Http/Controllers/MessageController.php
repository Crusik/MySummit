<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    // Get all messages (optionally filter by conversation)
    public function index(Request $request)
    {
        $query = Message::with(['sender', 'conversation']);

        if ($request -> has('conversation_id')) {
            $query -> where('conversation_id', $request -> conversation_id);
        }

        $messages = $query -> orderBy('created_at', 'asc') -> get();
        return response() -> json($messages);
    }

    // Store a new message
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'conversation_id' => 'required|exists:conversations,id',
            'sender_id' => 'required|exists:users,id',
            'text' => 'required|string',
            'is_read' => 'boolean'
        ]);

        $message = Message::create($validated);
        return response() -> json($message, 201);
    }
}
