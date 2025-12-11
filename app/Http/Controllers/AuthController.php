<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        // Fetch all users
        $users = User::all();
        // Return view and pass the $users variable
        return view('admin.users', compact('users'));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
       public function login(Request $request)
    {
        // Validate and attempt login
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            // Storing custom data in the session after successful login
            session(['custom_flag' => 'some_value']);
    
            return redirect()->route('shop')->with('success', 'Login successful!');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // public function login(Request $request)
    // {

    //     $validateUser = Validator::make(
    //         $request->all(),
    //         [
    //             'email' => 'required|email',
    //             'password' => 'required|min:6'
    //         ]

    //     );
    //     if ($validateUser->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Authentication  failed',
    //             'error' => $validateUser->errors()->all(),
    //         ], 422);
    //     }

    //     // Validate and attempt login
    //     if (Auth::attempt([
    //         'email' => $request->email,
    //         'password' => $request->password,
    //     ])) {
    //         // Storing custom data in the session after successful login
    //         session(['custom_flag' => 'some_value']);



    //        if ($request->is('api/*') || $request->wantsJson()) {
    //          return response()->json([
    //             'status' => 'success',
    //             'message' => 'Login successful!',
    //             'token' => Auth::user()->createToken('auth_token')->plainTextToken,
    //             'token_type' => 'bearer',
    //             'redirect_url' => route('shop'),
    //         ], 200);
    //        }

    //         return redirect()->route('shop')->with('success', 'Login successful!');
    //     } else {
    //         // If login fails, return an error response
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid credentials',
    //         ], 401);
    //         return back()->withErrors(['email' => 'Invalid credentials']);
    //     }
    // }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'

            ]

        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validateUser->errors()->all(),
            ], 422);
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful!',
            'redirect_url' => route('login'),
        ], 201);
        // return redirect('/login')->with('success', 'Registration successful!');

        // $request->validate([

        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6|confirmed'
        // ]);

        // 


    }

    public function sendResetOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        Mail::raw(
            "Your OTP for password reset is: $otp\n\nThis OTP is valid for 5 minutes.\n\nIf you did not request this, ignore this email.",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject("Password Reset OTP");
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email'
        ]);
    }

    // ✅ VERIFY OTP (WITH 5 MINUTE EXPIRY)
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required'
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        // ✅ OTP Expiry: 5 minutes
        if (Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified'
        ]);
    }

    // ✅ RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $user->tokens()->delete(); 
         
        if($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Logout successful!'
            ], 200);

        }
        return redirect('/login')->with('success', 'Logout successful!');
    }
}
