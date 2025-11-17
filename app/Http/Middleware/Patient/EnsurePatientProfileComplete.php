<?php

namespace App\Http\Middleware\Patient;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePatientProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If not logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // If email not verified, redirect to verification page
        if ($user->email_verified == 0) {
            return redirect()->route('verify.pin.form')
                ->with('error', 'Please verify your email first.');
        }

        // For patient role → check profile completion
        if ($user->role === 'patient') {
            if (!$user->patient) {
                return redirect()->route('profile.complete');
            }
        }

        return $next($request);
    }
}
