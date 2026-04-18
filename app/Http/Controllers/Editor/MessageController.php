<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Auth::user()->receivedMessages()
                        ->with('sender')
                        ->latest()
                        ->paginate(15);

        return view('editor.messages.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'article_id'  => 'nullable|exists:articles,id',
            'subject'     => 'required|string|max:255',
            'body'        => 'required|string',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'article_id'  => $request->article_id,
            'subject'     => $request->subject,
            'body'        => $request->body,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}