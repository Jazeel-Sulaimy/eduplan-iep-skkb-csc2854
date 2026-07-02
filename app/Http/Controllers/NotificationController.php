<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        abort_unless((int) $notification->user_id === (int) auth()->id(), 403);

        $notification->update(['is_read' => true]);

        return back()->with('success', __('messages.notification_marked_read'));
    }
}
