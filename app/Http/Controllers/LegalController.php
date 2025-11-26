<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TermsAcceptance;
use Illuminate\Http\Request;

class LegalController extends Controller
{
public function acceptTerms(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'accepted' => 'required|boolean'
        ]);

        $data = TermsAcceptance::updateOrCreate(
            ['user_id' => $request->user_id],
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
        $user = TermsAcceptance::where('user_id', $request->user_id)->first();

        return response()->json([
            'accepted' => $user?->accepted ?? false
        ]);
    }
}
