@php $role = auth()->user()->role; @endphp 
<div class="flex" style="height: calc(100vh - 8rem);" wire:poll.3s="refreshMessages">

    <!-- Sidebar -->
    <div class="w-1/3 border-r bg-gray-50 flex flex-col">
        <h3 class="p-4 font-bold text-lg border-b">Ongoing Chats</h3>
        <div class="flex-1 overflow-y-auto no-scrollbar">
            @if($ongoingUsers->isEmpty())
                <div class="p-4 text-gray-500">No ongoing chats</div>
            @else
                @foreach($ongoingUsers as $user)
                    <div wire:click="selectUser({{ $user->id }})"
                        class="flex items-center justify-between p-3 border-b cursor-pointer hover:bg-gray-100 {{ $selectedUser && $selectedUser->id == $user->id ? 'bg-gray-200' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                                @if($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover" alt="User">
                                @else
                                    <img src="{{ $user->profile_photo_url }}" class="w-full h-full object-cover" alt="User">
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-800 font-semibold">{{ $user->first_name . ' '. $user->last_name }} @if($role=='admin') ({{$user->role}}) @endif</span>
                                <span class="text-xs text-gray-600 truncate w-40">{{ $user->lastMessage ?? 'No messages yet' }}</span>
                            </div>
                        </div>
                        @if($user->unreadCount>0)
                            <div class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $user->unreadCount }}</div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <h3 class="p-4 font-bold text-lg border-t border-b">Explore Users</h3>
        <div class="flex-1 overflow-y-auto no-scrollbar">
            @if($allUsers->isEmpty())
                <div class="p-4 text-gray-500">No other users</div>
            @else
                @foreach($allUsers as $user)
                    <div wire:click="selectUser({{ $user->id }})"
                        class="flex items-center justify-between p-3 border-b cursor-pointer hover:bg-gray-100 {{ $selectedUser && $selectedUser->id == $user->id ? 'bg-gray-200' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                                @if($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover" alt="User">
                                @else
                                    <img src="{{ $user->profile_photo_url }}" class="w-full h-full object-cover" alt="User">
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-800 font-semibold">{{ $user->first_name . ' '. $user->last_name }} @if($role=='admin') ({{$user->role}}) @endif</span>
                                <span class="text-xs text-gray-600 truncate w-40">{{ $user->lastMessage ?? 'No messages yet' }}</span>
                            </div>
                        </div>
                        @if($user->unreadCount>0)
                            <div class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $user->unreadCount }}</div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Main Chat Area (same as before, with profile images handled similarly) -->
    <div class="w-2/3 flex flex-col h-full">
        @if($selectedUser)
            <div class="flex items-center justify-between p-4 border-b bg-gray-100 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <button wire:click="exitChat" class="text-gray-600 hover:text-red-500 text-lg font-bold"> ← </button>
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                        @if($selectedUser->profile_photo_path)
                            <img src="{{ asset('storage/' . $selectedUser->profile_photo_path) }}" class="w-full h-full object-cover" alt="User">
                        @else
                            <img src="{{ $selectedUser->profile_photo_url }}" class="w-full h-full object-cover" alt="User">
                        @endif
                    </div>
                    <h2 class="font-bold text-lg">{{ $selectedUser->name }}</h2>
                </div>
            </div>

            <!-- Messages + input same as previous code -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <div class="flex-1 overflow-y-auto p-4 space-y-3" id="messagesContainer">
                    @php $unreadSeparatorShown = false; @endphp
                    @foreach($messages as $message)
                        @if(!$unreadSeparatorShown && $message->sender_id==$selectedUser->id && $message->seen==0)
                            <div class="flex justify-center">
                                <div class="text-xs text-gray-500 border-b w-full text-center my-2">Unread Messages</div>
                            </div>
                            @php $unreadSeparatorShown=true; @endphp
                        @endif
                        @if(($message->sender_id==auth()->id() && $message->deleted_by_sender) || ($message->receiver_id==auth()->id() && $message->deleted_by_receiver))
                            @continue
                        @endif
                        <div class="flex {{ $message->sender_id==auth()->id() ? 'justify-end':'justify-start' }}">
                            <div class="relative max-w-xs px-3 py-2 rounded-lg {{ $message->sender_id==auth()->id()?'bg-blue-500 text-white':'bg-gray-200 text-gray-800' }}">
                                <div>{{ $message->message }}</div>
                                <div class="text-xs text-gray-600 mt-1 flex items-center justify-between">
                                    <span>{{ $message->created_at->format('H:i') }}</span>
                                    @if($message->sender_id==auth()->id())
                                        @if($message->seen)
                                            <span class="ml-2 text-green-300">✓✓</span>
                                        @else
                                            <span class="ml-2 text-gray-300">✓</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex-shrink-0 border-t bg-gray-50 p-4 flex gap-2">
                    <input type="text" wire:model.defer="newMessage" wire:keydown.enter="sendMessage" placeholder="Type a message..." class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                    <button wire:click="sendMessage" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Send</button>
                </div>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-500">Select a user to start chatting</div>
        @endif
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>

<script>
document.addEventListener('livewire:load', function() {
    const container = document.getElementById('messagesContainer');
    function scrollToBottom(){ if(container) container.scrollTop=container.scrollHeight; }
    scrollToBottom();
    Livewire.hook('message.processed', () => { scrollToBottom(); });
});
</script>
