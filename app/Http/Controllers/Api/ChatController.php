<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $authId = Auth::id();

        $messages = Chat::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $authId);
            })
            ->oldest()
            ->get();

        return response()->json($messages);
    }

    /**
     * API: Store a new message.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string',
            'type'        => 'nullable|string',
            'ref'         => 'nullable|string',
        ]);

        $chat = Chat::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $data['receiver_id'],
            'message'     => $data['message'],
            'type'        => $data['type'] ?? 'text',
            'ref'         => $data['ref'] ?? null,
        ]);

        return response()->json($chat, 201);
    }

    /**
     * API: Mark all messages from a user as seen.
     */
    public function markAsSeen($userId)
    {
        Chat::where('receiver_id', Auth::id())
            ->where('sender_id', $userId)
            ->update(['seen' => true]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * UI: Show chat page with users but no conversation selected.
     */
    public function showChatPage()
    {
        $authId = Auth::id();
        $role = Auth::user()->role;

        $partnerIds = Chat::where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->get()
            ->map(fn($chat) => $chat->sender_id == $authId ? $chat->receiver_id : $chat->sender_id)
            ->unique()
            ->values();

        $users = User::whereIn('id', $partnerIds)->get();

        if($role === 'admin') {
            return view('chat.admin_chat', [
                'users'        => $users,
                'selectedUser' => null,
                'messages'     => collect(),
            ]);
        }
        if($role === 'member') {
            return view('chat.member_chat', [
            'users'        => $users,
            'selectedUser' => null,
            'messages'     => collect(),
        ]);
        }
    }


    public function openChat($userId)
    {
        $authId = Auth::id();

        $users = User::where('id', '!=', $authId)->get();
        $selectedUser = User::findOrFail($userId);

        $messages = Chat::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $authId);
            })
            ->oldest()
            ->get();

        return view('chat.chat', compact('users', 'selectedUser', 'messages'));
    }

    /**
     * Delete message for the current user only.
     */
    public function deleteForMe($messageId)
    {
        $authId  = Auth::id();
        $message = Chat::findOrFail($messageId);

        if ($message->sender_id === $authId) {
            $message->update(['deleted_by_sender' => true]);
        } elseif ($message->receiver_id === $authId) {
            $message->update(['deleted_by_receiver' => true]);
        }

        return response()->json(['status' => 'deleted_for_me']);
    }

    /**
     * Delete message for everyone.
     */
    public function deleteForEveryone($messageId)
    {
        $authId  = Auth::id();
        $message = Chat::findOrFail($messageId);

        if ($message->sender_id === $authId) {
            $message->update([
                'message' => null,
                'type'    => 'deleted',
            ]);
        }

        return response()->json(['status' => 'deleted_for_everyone']);
    }
}
