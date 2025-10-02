<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index($userId)
    {
        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'type'    => 'nullable|string|max:255',
            'ref'     => 'nullable|string|max:255',
        ]);

        $notification = Notification::create($validated);

        return response()->json($notification, 201);
    }

    public function show(string $id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json($notification);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function markAllAsRead($userId)
    {
        Notification::where('user_id', $userId)->update(['is_read' => true]);
        return response()->json(['message' => 'All notifications marked as read']);
    }
}
