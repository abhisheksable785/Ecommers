<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage; // Storage facade import karo

class AdminController extends Controller
{
    /**
     * Dikhane ke liye admin profile page.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function loginPage()
    {
        return view('admin.login.login');
    }
    public function show()
    {
        // Currently logged in admin ka data fetch karo
        $admin = Auth::guard('admin')->user();
        // Sahi view 'admin.profile' ko data ke saath return karo
        return view('admin.profile.admin-profile', compact('admin'));
    }
    public function master()
    {
        // Currently logged in admin ka data fetch karo
        $admin = Auth::guard('admin')->user();
        // Sahi view 'admin.profile' ko data ke saath return karo
        return view('layout.back.master', compact('admin'));
    }

    /**
     * Admin ki profile details update karo.
     */
   public function updateProfile(Request $request)
{
    $adminId = Auth::guard('admin')->id();
    $admin = Admin::findOrFail($adminId);

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:admins,email,' . $adminId,
        'phone' => 'required|string|max:15|unique:admins,phone,' . $adminId,
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10023',
    ]);

    $admin->name  = $request->name;
    $admin->email = $request->email;
    $admin->phone = $request->phone;

    // Photo upload
    if ($request->hasFile('photo')) {
        // Purani photo delete
        if ($admin->photo && file_exists(public_path('uploads/' . $admin->photo))) {
            unlink(public_path('uploads/' . $admin->photo));
        }

        // New photo save
        $filename = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/admin_photos'), $filename);

        $admin->photo = 'admin_photos/' . $filename;
    }

    $admin->save();

    return back()->with('success', 'Profile updated successfully!');
}


    /**
     * Admin ka password change karo.
     */
    public function updatePassword(Request $request)
    {
        // Validation rules
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        // Current password check karo
        if (!Hash::check($request->current_password, $admin->password)) {
            return Redirect::back()->with('error', 'Current Password does not match!');
        }

        // Naya password update karo
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return Redirect::back()->with('success', 'Password Changed Successfully!');
    }


    
    public function login(Request $request)
    {
        // 1. Validate Input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Remember Me functionality
        $remember = $request->has('remember');

        // 3. Attempt Login using 'admin' guard
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Secure session fixation
            return redirect()->intended(route('admin.dashboard'))
                             ->with('success', 'Welcome back, Admin!');
        }

        // 4. Login Failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
                         ->with('success', 'Logged out successfully.');
    }

    // Dashboard (Example method)
   
}

