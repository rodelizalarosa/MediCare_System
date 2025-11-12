<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'sex' => 'required',
            'email' => 'required|email|unique:tbl_users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Check if patient record already exists
        $existingPatient = Patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('birth_date', $request->birth_date)
            ->where('sex', $request->sex)
            ->first();

        if ($existingPatient) {
            return back()->with('error', 'You already have a record. Please visit the clinic to activate your account.');
        }

        // Create verification token + 6-digit PIN
        $verifyToken = Str::random(50);
        $pin = rand(100000, 999999);

        // Create User
        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'patient',
            'email_verified' => 0,
            'verify_token' => $verifyToken,
            'verification_pin' => $pin,
            'status' => 'Pending',
        ]);

        // Send email
        Mail::send('emails.verify_pin', [
            'name' => $request->first_name,
            'pin' => $pin
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your MediCare Verification Code');
        });

        return redirect()->route('verify.pin.form')
            ->with('message', 'Registration successful! A verification PIN has been sent to your email.');
    }

}
