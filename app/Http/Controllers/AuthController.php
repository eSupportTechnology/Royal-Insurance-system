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


    Auth::guard('admin')->login($admin);

    return redirect()->route('dashboard')->with('success', 'Registration successful. Welcome!');
}


    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


public function logout(Request $request)
{
    Auth::guard('admin')->logout(); // <- logout from admin guard
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login.form')->with('success', 'You have been logged out.');
}


    public function dashboard()
    {
        return view('AdminDashboard.home');
    }

    public function account(){
        return view('profile.account');
    }

    public function accountUpdate(Request $request)
{
    $admin = Auth::guard('admin')->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
        'current_password' => 'nullable|string',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    if ($request->filled('current_password') && !Hash::check($request->current_password, $admin->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    $admin->name = $request->name;
    $admin->email = $request->email;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return back()->with('success', 'Account updated successfully!');
}
}
