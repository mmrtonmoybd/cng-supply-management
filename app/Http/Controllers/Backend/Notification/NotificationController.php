<?php

namespace App\Http\Controllers\Backend\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetch(Request $request)
    {
        $user = $request->user();
        $perPage = 6;

        $unread = $user->unreadNotifications()->paginate($perPage, ['*'], 'unread_page');
        $read = $user->readNotifications()->paginate($perPage, ['*'], 'read_page');

        return response()->json([
            'unread' => $unread,
            'read' => $read,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }

    public function markSingleRead(Request $request, $id)
    {
        $notification = $request->user()->unreadNotifications()->find($id);
        if ($notification) {
            $notification->markAsRead();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'not_found'], 404);
    }

    public function all(Request $request)
    {
        $user = $request->user();
        $perPage = 15;
        $notifications = $user->notifications()->paginate($perPage);

        return view('backend.notification.all', compact('notifications'));
    }
}
