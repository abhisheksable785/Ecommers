<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\OneSignalHelper;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function create()
    {
        // Optimization: Only get users who actually have a player_id
        $users = User::whereNotNull('player_id')->select('id', 'name', 'email', 'player_id')->get();
        return view('admin.notifications.index', compact('users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'message'        => 'required|string',
            'recipient_type' => 'required|in:all,specific',
            'user_id'        => 'required_if:recipient_type,specific',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'scheduled_at'   => 'nullable|date|after:now', // Ensure schedule is in future
        ]);

        // 1. Handle Image Upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/notifications'), $imageName);
        }

        // 2. Determine Targets
        $targets = collect(); // Collection to hold target users

        if ($request->recipient_type === 'all') {
            $targets = User::whereNotNull('player_id')->get();
        } else {
            $user = User::where('id', $request->user_id)->whereNotNull('player_id')->first();
            if($user) {
                $targets->push($user);
            }
        }

        if ($targets->isEmpty()) {
            return back()->with('error', '❌ No valid users found with OneSignal Player IDs.');
        }

        // 3. Extract Player IDs for API (One Batch Request)
        $playerIds = $targets->pluck('player_id')->toArray();

        // 4. Send to OneSignal (Optimized: 1 API Call)
        $apiResult = OneSignalHelper::sendToUser(
            $playerIds,
            $request->title,
            $request->message,
            $imageName,
            $request->action_url,
            $request->scheduled_at // Logic handled in Helper now
        );

        // 5. Bulk Log to Database (Optimized: 1 DB Query instead of N loops)
        $notificationsData = [];
        $now = Carbon::now();

        foreach ($targets as $target) {
            $notificationsData[] = [
                'user_id'      => $target->id,
                'title'        => $request->title,
                'message'      => $request->message,
                'image'        => $imageName,
                'player_id'    => $target->player_id,
                'priority'     => $request->priority ?? 'normal',
                'action_url'   => $request->action_url,
                'scheduled_at' => $request->scheduled_at,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        // Chunk insert to prevent memory issues if sending to 10k users
        foreach (array_chunk($notificationsData, 500) as $chunk) {
            Notification::insert($chunk);
        }

        return back()->with('success', '✅ Notification Processed Successfully!');
    }
}