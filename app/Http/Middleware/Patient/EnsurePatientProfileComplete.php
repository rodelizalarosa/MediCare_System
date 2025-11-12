<?php

namespace App\Http\Middleware\Patient;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePatientProfileIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If not logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // If email not verified, block access
        if ($user->email_verified == 0) {
            return redirect()->route('login')
                ->with('error', 'Please verify your email first.');
        }

        // For patient role → check profile completion
        if ($user->role === 'patient') {
            if (!$user->patient) {
                return redirect()->route('profile.complete')
                    ->with('message', 'Please complete your patient profile first.');
            }
        }

        return $next($request);
    }
}
