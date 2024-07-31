<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\Notification; // Importe o modelo Notification


class NotificationController extends Controller
{
    public function index()
    {   
        $notifications = Notification::with('evaluation')->orderBy('created_at', 'desc')->get();
        $sumUnread = $notifications->where('reading', false)->count();
        return view('notifications.notification', compact('notifications', 'sumUnread',));
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
