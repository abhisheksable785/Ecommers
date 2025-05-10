<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        // Fetch all users
        $users = User::all();
        
        // Return view and pass the $users variable
        return view('admin.users', compact('users'));
    }

    public function showLoginForm() {
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
    
            // return redirect()->route('dashboard');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success', 'Registration successful!');
    }

    public function logout()
    {
        Auth::logout(); // Logout the user
        session()->invalidate(); // Invalidate the session
        session()->regenerateToken(); // Regenerate the CSRF token
    
        return redirect()->route('login');
    }
}
