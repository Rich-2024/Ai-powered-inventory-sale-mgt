<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Attempt login without status check
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Check user status
        if ($user->status === 'suspended') {
            Auth::logout();  // log them out immediately
            return redirect()->route('suspension.page')  // define this route
                ->with('error', 'Your account has been suspended.');
        }

        if ($user->status !== 'active') {
            Auth::logout();
            return back()->with('error', 'Your account is not active.');
        }

        // If active, regenerate session and redirect as usual
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'employee') {
            return redirect()->route('employee.dashboard');
        }

        Auth::logout();
        return back()->with('error', 'Unauthorized user role.');
    }

    return back()->with('error', 'Invalid credentials.');
}



   public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Flash logout success message
    return redirect()->route('login')->with('message', 'Logout successful.');
}


    public function showRegistrationForm()
    {


        return view('auth.register');
    }

    // Store new user (admin creates new user)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => 'active',
        ]);

        return redirect()->route('login')->with('success', 'User registered successfully.');
    }
}
