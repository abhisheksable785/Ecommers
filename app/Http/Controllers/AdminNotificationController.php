<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OneSignal;

class AdminNotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'type' => 'required',
        ]);

        if ($request->type === 'push') {
            \OneSignal::sendNotificationToAll(
                $request->message,
                null,
                null,
                null,
                $request->title
            );
        }

        if ($request->type === 'email') {
            // your email code here
        }

        if ($request->type === 'sms') {
            // your SMS code here
        }

        if ($request->type === 'popup') {
            // store in database to show in frontend
        }

        return back()->with('success', 'Notification sent successfully!');
    }
}
