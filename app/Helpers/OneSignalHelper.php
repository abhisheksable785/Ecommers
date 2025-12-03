<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalHelper
{
    public static function sendToUser($playerId, $title, $message)
    {
        $appId  = env('ONESIGNAL_APP_ID');
        $apiKey = env('ONESIGNAL_API_KEY');

        if (!$appId || !$apiKey) {
            Log::error("❌ OneSignal Config Missing!");
            return false;
        }

        $payload = [
            "app_id" => $appId,
            "include_player_ids" => [$playerId],
            "headings" => ["en" => $title],
            "contents" => ["en" => $message],
            "priority" => 10,
        ];

        Log::info("OneSignal Payload: " . json_encode($payload));

        $response = Http::withHeaders([
            "Authorization" => "key ".$apiKey,   // ✅ यही MAIN FIX है
            "Content-Type"  => "application/json",
            "Accept"        => "application/json",
        ])->post("https://api.onesignal.com/notifications", $payload);

        Log::info("OneSignal Response: " . $response->body());

        return $response->json();
    }
}
