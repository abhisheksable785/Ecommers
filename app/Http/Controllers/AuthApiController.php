<?php

namespace App\Http\Controllers;

use App\Helpers\OneSignalHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'name' => 'required',
        'google_id' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,
            'profile' => $request->profile,
            'password' => bcrypt(Str::random(16)),
        ]);
    }

    $token = $user->createToken("google-token")->plainTextToken;

    return response()->json([
        "success" => true,
        "token" => $token,
        "user" => $user
    ]);
}

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user,
        ], 200);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function deleteAccount(Request $request)
{
    $user = $request->user();

    // ✅ Optional but recommended (logout from all devices)
    $user->tokens()->delete();

    // ✅ This will auto-delete data from ALL tables
    // jahan user_id foreign key me cascade laga hai
    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'Account and all related data deleted successfully',
    ]);
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',

        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user->onesignal_player_id) {
        OneSignalHelper::sendToUser(
            $user->onesignal_player_id,
            "Welcome to BMT Fashions 🎉",
            "Thanks for joining us, {$user->name}!"
        );
    }
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
{
    try {
        // Delete the token that was used for the current request
        // $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to logout',
            'error' => $e->getMessage(),
        ], 500);
    }
}



}
