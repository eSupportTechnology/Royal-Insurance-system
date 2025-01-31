<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm(){

    return view('authentication.sign-up');
 }

   public function signup(Request $request){

    $request->validate([
        'firstname'=> 'required|string|max:255',
        'lastname'=> 'required|string|max:255',
        'email'=> 'required|string|email|max:255|unique:users',
        'password'=> 'required|string|min:8',
    ]);

    $fullname = $request->firstname . ' ' . $request->lastname;
    
    $user = User::create([
        'name' => $fullname,
        'email' => $request->email,
        'password' => Hash::make($request->password),

    ]);

    Auth::login($user);
    
    return redirect()->route("index")->with('success','Registration Successful.');

   }

   public function showLoginForm(){

    return view('authentication.login');
 }

 public function login(Request $request){

    $request->validate([
        'email'=> 'required|email',
        'password'=> 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))){
        return redirect()->route('index');
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
 }

 public function logout(Request $request)
 {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login.form')->with('success' , 'You have been logged out.');

 }
}