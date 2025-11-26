<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TermsAcceptance;
use Illuminate\Http\Request;

class LegalController extends Controller
{
public function acceptTerms(Request $request)
{
    // Validation (no user_id required)
    $request->validate([
        'accepted' => 'required|boolean'
    ]);

    // Get logged-in user via token
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    // Save acceptance
    $data = TermsAcceptance::updateOrCreate(
        ['user_id' => $user->id], // coming from token
        [
            'accepted' => $request->accepted,
            'accepted_at' => now()
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'User acceptance recorded',
        'data' => $data
    ]);
}


public function checkTerms(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(['accepted' => false]);
    }

    $accepted = TermsAcceptance::where('user_id', $user->id)->value('accepted');

    return response()->json([
        'accepted' => $accepted ?? false
    ]);
}

}
