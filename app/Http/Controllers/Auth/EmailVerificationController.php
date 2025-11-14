<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function showPinForm()
    {
        return view('auth.verify-pin');
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_pin', trim($request->pin))
                    ->first();

        if (!$user) {
            return back()->with('error', 'Incorrect PIN or email.');
        }

        if (!$user->pin_created_at || Carbon::parse($user->pin_created_at)->addMinutes(15)->isPast()) {
            return back()->with('error', 'The PIN has expired. Please request a new one.');
        }

        $user->update([
            'email_verified' => 1,
            'verification_pin' => null,
            'verify_token' => null,
            'pin_created_at' => null,
            'status' => 'Active'
        ]);

        return redirect()->route('login')
                         ->with('message', 'Email verified successfully. You may now login.');
        }

    public function resendPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified) {
            return back()->with('error', 'This email is already verified.');
        }

        // Generate new PIN
        $newPin = rand(100000, 999999);

        $user->update([
            'verification_pin' => $newPin,
            'pin_created_at' => now(),
        ]);

        // Safe name fallback
        $name = $user->patient->first_name ?? $user->name ?? 'User';

        // Send email
        Mail::send('emails.verify_pin', [
            'name' => $name,
            'pin' => $newPin
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your New MediCare Verification PIN');
        });

        // In resendPin method - this is already correct:
        return back()->with('message', 'A new verification PIN has been sent to your email.');
    }
}
