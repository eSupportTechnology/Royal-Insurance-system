<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\RepAuth;
use App\Models\SubAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RepAuthController extends Controller
{

    public function registerForm()
    {
        return view('authentication.rep-register');
    }

    public function checkCode(Request $request)
    {
        $code = $request->code;

        $exists = Agent::where('rep_code', $code)->exists() ||
            SubAgent::where('sub_agent_rep_code', $code)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if code exists in agents or sub_agents
        $codeExists = Agent::where('rep_code', $request->code)->exists() ||
            SubAgent::where('sub_agent_rep_code', $request->code)->exists();

        if (!$codeExists) {
            return back()->withErrors(['code' => 'Invalid or ineligible code.']);
        }

        // Prevent duplicate registration with the same code
        if (RepAuth::where('code', $request->code)->exists()) {
            return back()->withErrors(['code' => 'This code is already registered.']);
        }

        $role = Agent::where('rep_code', $request->code)->exists() ? 'agent' : 'subagent';
        // Create rep user
        $rep = RepAuth::create([
            'code' => $request->code,
            'role' => $role,
            'password' => Hash::make($request->password),
        ]);

        // Login the rep user
        Auth::guard('rep')->login($rep);

        return redirect()->route('rep.dashboard')->with('success', 'Registration successful. Welcome!');
    }


    public function loginForm()
    {
        return view('authentication.rep-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'password' => 'required|string',
        ]);

        $rep = RepAuth::where('code', $request->code)->first();

        if ($rep && Hash::check($request->password, $rep->password)) {
            Auth::guard('rep')->login($rep);
            return redirect()->route('rep.dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid code or password.');
    }

    public function dashboard()
    {
        return view('RepDashboard.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('rep')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('rep.login.form')->with('success', 'You have been logged out.');
    }
}
