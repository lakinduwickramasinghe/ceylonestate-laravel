<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatWindow extends Component
{
    public $ongoingUsers = [];
    public $allUsers = [];
    public $selectedUser = null;
    public $messages = [];
    public $newMessage = '';

    public function mount()
    {
        $this->loadUsers();
    }

    /**
     * Load users for sidebar.
     */
    public function loadUsers()
    {
        $authId = Auth::id();

        // All users except current
        $allUsersCollection = User::where('id', '<>', $authId)->get();

        // Fetch ongoing chat partner IDs
        $sentTo = Chat::where('sender_id', $authId)->pluck('receiver_id');
        $receivedFrom = Chat::where('receiver_id', $authId)->pluck('sender_id');

        $ongoingIds = $sentTo->merge($receivedFrom)->unique();

        // Ongoing users
        $this->ongoingUsers = $allUsersCollection->filter(fn($u) => $ongoingIds->contains($u->id))
            ->map(function ($user) use ($authId) {
                $this->attachMessageData($user, $authId);
                return $user;
            })
            ->sortByDesc(fn($u) => $u->lastMessageTime ? $u->lastMessageTime->timestamp : 0)
            ->values();

        // Explore / other users
        $this->allUsers = $allUsersCollection->filter(fn($u) => !$ongoingIds->contains($u->id))
            ->map(function ($user) use ($authId) {
                $this->attachMessageData($user, $authId);
                return $user;
            })
            ->sortBy('name')
            ->values();
    }

    /**
     * Attach last message, time, unread count.
     */
    private function attachMessageData($user, $authId)
    {
        $lastMessage = Chat::where(function ($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastMessage) {
            $preview = '';
            if ($lastMessage->type === 'quotation') {
                $preview = '[Quotation] ' . ($lastMessage->ref ?? ($lastMessage->message ? Str::limit($lastMessage->message, 40) : 'New quotation'));
            } else {
                $previewText = $lastMessage->message ?? '';
                $preview = ($lastMessage->sender_id == $authId ? 'You: ' : '') . Str::limit($previewText, 40);
            }
            $user->lastMessage = $preview;
            $user->lastMessageTime = $lastMessage->created_at;
        } else {
            $user->lastMessage = null;
            $user->lastMessageTime = null;
        }

        $user->unreadCount = Chat::where('sender_id', $user->id)
            ->where('receiver_id', $authId)
            ->where('seen', 0)
            ->count();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);

        Chat::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('seen', 0)
            ->update(['seen' => 1]);

        $this->loadMessages();
        $this->loadUsers();
    }

    public function exitChat()
    {
        $this->selectedUser = null;
        $this->messages = [];
        $this->loadUsers();
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) return;

        $authId = Auth::id();
        $otherId = $this->selectedUser->id;

        $this->messages = Chat::where(function ($q) use ($authId, $otherId) {
                $q->where('sender_id', $authId)->where('receiver_id', $otherId);
            })
            ->orWhere(function ($q) use ($authId, $otherId) {
                $q->where('sender_id', $otherId)->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        Chat::where('sender_id', $otherId)
            ->where('receiver_id', $authId)
            ->where('seen', 0)
            ->update(['seen' => 1]);
    }

    public function sendMessage()
    {
        if (!$this->newMessage || !$this->selectedUser) return;

        Chat::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $this->selectedUser->id,
            'message'     => $this->newMessage,
            'type'        => 'text',
            'seen'        => 0,
        ]);

        $this->newMessage = '';
        $this->loadMessages();
        $this->loadUsers();
    }

    public function refreshMessages()
    {
        if ($this->selectedUser) $this->loadMessages();
        $this->loadUsers();
    }

    public function deleteForMe($messageId)
    {
        $msg = Chat::find($messageId);
        if (!$msg) return;
        if ($msg->sender_id == Auth::id()) $msg->deleted_by_sender = true;
        elseif ($msg->receiver_id == Auth::id()) $msg->deleted_by_receiver = true;
        $msg->save();
        $this->refreshMessages();
    }

    public function deleteForEveryone($messageId)
    {
        $msg = Chat::find($messageId);
        if (!$msg) return;
        if ($msg->sender_id == Auth::id()) $msg->update(['message'=>null,'type'=>'deleted']);
        $this->refreshMessages();
    }

    public function render()
    {
        return view('livewire.chat-window');
    }
}
