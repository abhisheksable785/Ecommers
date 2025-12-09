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



}
