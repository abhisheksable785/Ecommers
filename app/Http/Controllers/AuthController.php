<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;
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
