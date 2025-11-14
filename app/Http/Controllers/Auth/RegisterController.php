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
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'sex' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',       // at least one uppercase letter
                'regex:/[a-z]/',       // at least one lowercase letter
                'regex:/[0-9]/',       // at least one number
                'regex:/[@$!%*?&]/'    // at least one special character
            ],
        ]);

        // ✅ Check if account already exists using: first_name, middle_name, last_name, dob, sex, AND email
        // Check in users table for email
        $existingUser = User::where('email', $request->email)->first();
        
        // Check in patients table for duplicate identity (first, middle, last, dob, sex)
        $existingPatient = Patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('birth_date', $request->birth_date)
            ->where('sex', $request->sex);
        
        // If middle_name is provided, include it in the check
        if ($request->filled('middle_name')) {
            $existingPatient->where('middle_name', $request->middle_name);
        } else {
            $existingPatient->whereNull('middle_name');
        }
        
        $existingPatient = $existingPatient->first();

        // If email exists in users table
        if ($existingUser) {
            return back()->with('error', 'An account with this email already exists. Please login instead.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // If patient record with same identity exists
        if ($existingPatient) {
            return back()->with('error', 'A patient record with this information already exists. Please visit the clinic to activate your account.')
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // ✅ Create verification token + 6-digit PIN
        $verifyToken = Str::random(50);
        $pin = rand(100000, 999999);

        // ✅ Create User with email and password only
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'email_verified' => 0,
            'verify_token' => $verifyToken,
            'verification_pin' => $pin,
            'pin_created_at' => now(),
            'status' => 'Pending',
        ]);

        // ✅ Create basic Patient record with only: first_name, middle_name, last_name, dob, sex
        // Address, contact_number, and emergency contact will be filled in complete-profile
        Patient::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'birth_date' => $request->birth_date,
            'registration_source' => 'Online',
            'record_status' => 'Active',
            // Note: address, contact_number, emergency_contact fields are nullable and will be filled in complete-profile
        ]);

        // ✅ Send verification email with PIN
        Mail::send('emails.verify_pin', [
            'name' => $request->first_name,
            'pin' => $pin
        ], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your MediCare Verification Code');
        });

        // ✅ Redirect to verification page
        return redirect()->route('verify.pin.form')
            ->with('message', 'Registration successful! A verification PIN has been sent to your email. Please verify your email to continue.');
    }
}
