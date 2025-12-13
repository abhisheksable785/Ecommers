<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function savePlayerId(Request $request)
{ 
    $request->validate([
        'player_id' => 'required|string',
    ]);

    $user = auth()->user();

    if (!$user) {
        return response()->json([
            "success" => false,
            "message" => "User not authenticated"
        ], 401);
    }

    $user->onesignal_player_id = $request->player_id;
    $user->save();

    return response()->json([
        "success" => true,
        "message" => "Player ID saved successfully",
        "player_id" => $user->onesignal_player_id
    ]);
}

public function syncOneSignal(Request $request)
    {
        $request->validate([
            'onesignal_id' => 'required|string',
        ]);

        $user = $request->user();
        $user->onesignal_id = $request->onesignal_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'OneSignal ID synced successfully',
        ]);
    }

    // ✅ Toggle notification ON/OFF
    public function toggleNotification(Request $request)
    {
        $request->validate([
            'notifications' => 'required|boolean',
        ]);

        $user = $request->user();
        $user->notifications = $request->notifications;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Notification status updated',
            'notifications' => $user->notifications,
        ]);
    }




}
