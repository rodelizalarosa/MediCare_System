<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // trim inputs
        $credentials = [
            'email' => trim($request->input('email')),
            'password' => $request->input('password')
        ];

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();

        // Check if user is verified
        $notVerified = isset($user->email_verified)
            ? ! (bool) $user->email_verified
            : (method_exists($user, 'hasVerifiedEmail') ? ! $user->hasVerifiedEmail() : empty($user->email_verified_at));

        if ($notVerified) {
            Auth::logout();
            return redirect()->route('verify.pin.form')->with('error', 'Please verify your email before logging in.');
        }

        // Account status check
        if (isset($user->status) && strtolower($user->status) !== 'active') {
            Auth::logout();
            return back()->with('error', 'Account is not active.');
        }

        // Role-based redirects
        switch ($user->role) {
            case 'staff':
            case 'doctor':
            case 'midwife':
                return redirect()->route('dashboard.staff');
            case 'patient':
                // Check if patient profile is complete (has address)
                if ($user->patient && !empty($user->patient->address)) {
                    // Profile is complete, go to dashboard
                    return redirect()->route('dashboard.patient');
                } else {
                    // Profile not complete, redirect to complete-profile
                    return redirect()->route('profile.complete')
                        ->with('message', 'Please complete your profile to continue.');
                }
            default:
                return redirect('/');
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
