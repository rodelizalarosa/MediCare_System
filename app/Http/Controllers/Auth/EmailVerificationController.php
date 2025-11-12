<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerificationController extends Controller
{
    // Show PIN page
    public function showPinForm()
    {
        return view('auth.verify-pin');
    }

    // Validate PIN
    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_pin', $request->pin)
            ->first();

        if (!$user) {
            return back()->with('error', 'Incorrect PIN or email.');
        }

        // Activate email
        $user->email_verified = 1;
        $user->verification_pin = null;
        $user->verify_token = null;
        $user->status = 'Active';
        $user->save();

        return redirect()->route('login')
            ->with('message', 'Email verified successfully. You may now login.');
    }
}
