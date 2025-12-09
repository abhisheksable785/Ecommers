<?php

namespace App\Helpers;

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
    public static function sendToUser($playerIds, $title, $message, $image = null, $url = null, $scheduledAt = null)
    {
        $appId  = env('ONESIGNAL_APP_ID');
        $apiKey = env('ONESIGNAL_API_KEY');

        // Ensure playerIds is always an array
        $targetPlayerIds = is_array($playerIds) ? $playerIds : [$playerIds];

        // Filter out null/empty IDs
        $targetPlayerIds = array_filter($targetPlayerIds);

        if (!$appId || !$apiKey || empty($targetPlayerIds)) {
            Log::error("❌ OneSignal Config Missing or No Player IDs provided!");
            return false;
        }

        $payload = [
            "app_id" => $appId,
            "include_player_ids" => array_values($targetPlayerIds), // Reset array keys
            "headings" => ["en" => $title],
            "contents" => ["en" => $message],
            "priority" => 10,
        ];

        // ✅ IMAGE SUPPORT
        if ($image) {
            $imageUrl = asset('uploads/notifications/' . $image);
            $payload["big_picture"] = $imageUrl;       // Android
            $payload["ios_attachments"] = ["id" => $imageUrl]; // iOS
            $payload["chrome_web_image"] = $imageUrl;  // Web
        }

        // ✅ CLICK URL
        if ($url) {
            $payload["url"] = $url;
        }

        // ✅ SCHEDULING SUPPORT (send_after)
        if ($scheduledAt) {
            // OneSignal expects: "2015-09-24 14:00:00 GMT-0700"
            // We convert the input time to the required format with timezone
            $date = Carbon::parse($scheduledAt);
            $payload["send_after"] = $date->format('Y-m-d H:i:s') . ' GMT' . $date->format('O'); 
        }

        $response = Http::withHeaders([
            "Authorization" => "key " . $apiKey,
            "Content-Type"  => "application/json",
            "Accept"        => "application/json",
        ])->post("https://api.onesignal.com/notifications", $payload);

        if ($response->failed()) {
            Log::error("OneSignal Error: " . $response->body());
        } else {
            Log::info("OneSignal Success: " . $response->body());
        }

        return $response->json();
    }
}