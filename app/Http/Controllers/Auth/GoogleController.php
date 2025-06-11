<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

   public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        
        // Check if user exists by email or google_id
        $user = User::where('email', $googleUser->email)
                    ->orWhere('google_id', $googleUser->id)
                    ->first();
        
        if ($user) {
            // Update google_id if it's not set
            if (empty($user->google_id)) {
                $user->google_id = $googleUser->id;
                $user->save();
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make(Str::random(24)) // More secure than encrypt()
            ]);
        }
        
        Auth::login($user);
        return redirect('/')->with('status', 'Login Successful');

    } catch (\Exception $e) {
        Log::error('Google Auth Error: '.$e->getMessage());
        return redirect('/login')->with('error', 'Google authentication failed. Please try again.');
    }
}
}

