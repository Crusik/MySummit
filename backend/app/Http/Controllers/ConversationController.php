<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        // Return conversations for the authenticated user
        $conversations = $request -> user()
             -> conversations()
             -> with(['users', 'messages.sender'])
             -> get();
        return response() -> json($conversations);
    }

    public function show($id)
    {
        $conversation = Conversation::with(['users', 'messages.sender'])
            -> findOrFail($id);
        return response() -> json($conversation);
    }

    public function store(Request $request)
    {
        $validated = $request -> validate([
            'user_ids' => 'required|array|min:2',
            'user_ids.*' => 'exists:users,id'
        ]);

        $conversation = Conversation::create();

        // attach users to pivot
        $conversation -> users() -> attach($validated['user_ids']);

        return response() -> json($conversation -> load('users'));
    }
}