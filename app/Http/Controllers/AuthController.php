<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('authentication.sign-up');
    }

    public function signup(Request $request)
{
    // dd($request);
    $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:admins',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $fullname = $request->firstname . ' ' . $request->lastname;


    $admin = Admin::create([
        'name' => $fullname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);


    Auth::login($admin);

    return redirect()->route('login.form')->with('success', 'Registration successful. Welcome!');
}


    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        Auth::guard('admin')->user();

        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalidates the session
        $request->session()->regenerateToken(); // Regenerates the CSRF token

        // Redirect to the login form route
        return redirect()->route('login.form')->with('success', 'You have been logged out.');
    }

    public function dashboard()
    {
        return view('AdminDashboard.home');
    }


}
