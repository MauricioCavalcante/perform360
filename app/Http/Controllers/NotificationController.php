<?php

namespace App\Http\Controllers;

use App\Models\Notification; 
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');

        $query = Notification::with('evaluation')->orderBy('created_at', 'desc');

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $notifications = $query->get();
        $sumUnread = $notifications->where('reading', false)->count();

        return view('notifications.notification', compact('notifications', 'sumUnread', 'type'));
    }

    public function markReading($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['reading' => '1']);
        }

        return redirect()->back();
    }
}