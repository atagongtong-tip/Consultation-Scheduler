<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ User, Conversation, Message };
use App\Events\MessageEvent;

class InboxController extends Controller
{
    public function createAdminConversation()
    {
        $query = Conversation::with('participants')->orderBy('updated_at', 'DESC');
        $query->whereHas('participants', function($query) {
            $query->where(['user_id' => 1]);
        });
        $query->whereHas('participants', function($query) {
            $query->where(['user_id' => auth()->user()->id]);
        });
        if ($conversation = $query->first()) {
            return $conversation->id;
        }
        $conversation = Conversation::create([]);
        $conversation->participants()->create(['user_id' => 1]);
        $conversation->participants()->create(['user_id' => auth()->user()->id]);
        return $conversation->id;
    }

    public function index(Request $request)
    {
        if (auth()->user()->role->slug === 'user') {
            $this->createAdminConversation();
        }

        $query = Conversation::with('participants')->orderBy('updated_at', 'DESC');
        $query->whereHas('participants', function($query) use ($request) {
            $query->where(['user_id' => $request->user()->id]);
        });
        return view('inbox.index', [
            'conversations' => $query->get(),
        ]);
    }

    public function create(Request $request)
    {
        $query = Conversation::with('participants')->orderBy('updated_at', 'DESC');
        $query->whereHas('participants', function($query) use ($request) {
            $query->where(['user_id' => $request->user_id]);
        });
        $query->whereHas('participants', function($query) use ($request) {
            $query->where(['user_id' => $request->user()->id]);
        });
        if ($conversation = $query->first()) {
            if (! empty($request->message)) {
                $conversation->messages()->create([
                    'user_id' => $request->user()->id,
                    'message' => $request->message,
                ]);
            }
    
            return redirect(route('inbox.show', $conversation->id));
        }
        $conversation = Conversation::create([]);
        $conversation->participants()->create(['user_id' => $request->user_id]);
        $conversation->participants()->create(['user_id' => $request->user()->id]);
        if (! empty($request->message)) {
            $conversation->messages()->create([
                'user_id' => $request->user()->id,
                'message' => $request->message,
            ]);
        }
        return redirect(route('inbox.show', $conversation->id));
    }

    public function show($id, Request $request)
    {
        $conversation = Conversation::with(['participants', 'messages.user'])->find($id);
        $query = Conversation::with(['messages.user']);

        $query->whereHas('participants', function($query) use ($request) {
            $query->where(['user_id' => $request->user()->id]);
        });

        return view('inbox.index', [
            'conversations' => $query->get(),
            'conversation' => $conversation,
        ]);
    }

    public function send($id, Request $request)
    {
        $conversation = Conversation::with(['participants', 'messages.user'])->find($id);

        $message = $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        $message  = Message::with(['user'])->find($message->id);

        $conversation->touch();
        $conversation->participants()->touch();

        broadcast(new MessageEvent($message))->toOthers();

        return $message;
    }
}