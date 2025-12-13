<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OneSignalHelper
{
    /**
     * Send notification to one or multiple users
     * * @param array|string $playerIds - Single ID or Array of IDs
     * @param string $title
     * @param string $message
     * @param string|null $image
     * @param string|null $url
     * @param string|null $scheduledAt - YYYY-MM-DD HH:MM format
     */
   public static function sendToUser($userIds, $title, $message, $image = null, $url = null, $scheduledAt = null)
{
    $appId  = env('ONESIGNAL_APP_ID');
    $apiKey = env('ONESIGNAL_API_KEY');

    // Normalize input to array
    $userIds = is_array($userIds) ? $userIds : [$userIds];

    // Fetch users who:
    // 1) Enabled notifications
    // 2) Have valid OneSignal player ID
    $players = User::whereIn('id', $userIds)
        ->where('notifications', 1)                // 🔥 only users with notifications ON
        ->whereNotNull('onesignal_player_id')             // 🔥 must have a valid OneSignal ID
        ->pluck('onesignal_player_id')
        ->toArray();

    if (empty($players)) {
        Log::warning("No users eligible for OneSignal push (notifications off or no player ID).");
        return false;
    }

    $payload = [
        "app_id" => $appId,
        "include_player_ids" => $players,
        "headings" => ["en" => $title],
        "contents" => ["en" => $message],
        "priority" => 10,
    ];

    // Attach image if exists
    if ($image) {
        $imageUrl = asset('uploads/notifications/' . $image);
        $payload["big_picture"] = $imageUrl;
        $payload["chrome_web_image"] = $imageUrl;
        $payload["ios_attachments"] = ["id" => $imageUrl];
    }
    
    // URL click redirect
    if ($url) {
        $payload["url"] = $url;
    }

    // Scheduling
    if ($scheduledAt) {
        $date = Carbon::parse($scheduledAt);
        $payload["send_after"] = $date->format('Y-m-d H:i:s') . ' GMT' . $date->format('O');
    }

    $response = Http::withHeaders([
        "Authorization" => "Basic " . $apiKey,   // OneSignal uses Basic auth
        "Content-Type"  => "application/json",
    ])->post("https://api.onesignal.com/api/v1/notifications", $payload);

    if ($response->failed()) {
        Log::error("❌ OneSignal Error: " . $response->body());
    } else {
        Log::info("✔ OneSignal Success: " . $response->body());
    }

    return $response->json();
}

}