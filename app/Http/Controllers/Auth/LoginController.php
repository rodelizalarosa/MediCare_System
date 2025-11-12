<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt login
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();

        // Check email verified
        if (!$user->email_verified) {
            return back()->with('error', 'Please verify your email before logging in.');
        }

        // If role = patient AND profile incomplete
        if ($user->role === 'patient' && !$user->patient) {
            return redirect()->route('profile.complete')
                ->with('message', 'Please complete your patient profile.');
        }

        // Redirect based on role
        switch ($user->role) {
            case 'staff':
            case 'doctor':
            case 'midwife':
                return redirect()->route('dashboard.staff');

            case 'patient':
                return redirect()->route('dashboard.patient');

            default:
                return redirect('/'); // fallback
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Logged out successfully.');
    }
}
