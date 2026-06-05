<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'body' => 'required|string',
            // Add validation for attachment if needed
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'group_id' => $request->group_id,
            'body' => $request->body,
            'attachment' => $request->attachment ?? null,
            'seen' => false,
        ]);

        // Broadcast the message to the group
        // broadcast(new \App\Events\NewMessage($message));

        return response()->json(['message' => 'Message sent successfully', 'data' => $message], 201);
    }

    public function getGroupMessages(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);

        // Load the messages with user information
        $messages = $group->messages()->with('user')->get();

        return response()->json(['data' => $messages]);
    }
}
