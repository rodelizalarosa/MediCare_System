<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\MedicalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientProfileController extends Controller
{
    /**
     * Show the Complete Profile form
     */
    public function showCompleteForm()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Please login to continue.');
        }

        // If email not verified, redirect to verification page
        if ($user->email_verified == 0) {
            return redirect()->route('verify.pin.form')
                ->with('error', 'Please verify your email first.');
        }

        // If patient record exists and is complete (has address), redirect to dashboard
        if ($user->patient && !empty($user->patient->address)) {
            return redirect()->route('dashboard.patient');
        }

        // Show complete profile form
        return view('auth.complete-profile');
    }

    /**
     * Save completed patient profile
     */
    public function saveProfile(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_number' => 'required|string',
            'relationship_to_patient' => 'required|string',
        ]);

        $user = Auth::user();

        // Get existing patient record (created during registration)
        $patient = $user->patient;

        if (!$patient) {
            return back()->with('error', 'Patient record not found. Please contact support.')
                ->withInput();
        }

        /**
         * Update existing patient record with complete information
         */
        $patient->update([
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'relationship_to_patient' => $request->relationship_to_patient,
        ]);

        /**
         * Create empty medical history for this patient if it doesn't exist
         */
        if (!$patient->medicalHistory) {
            MedicalHistory::create([
                'patient_id' => $patient->id
            ]);
        }

        return redirect()->route('dashboard.patient')
            ->with('message', 'Your profile has been completed successfully.');
    }

    /**
     * Show the patient profile edit form
     */
    public function showProfile()
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('profile.complete')
                ->with('error', 'Patient record not found. Please complete your profile.');
        }

        return view('patient.profile', compact('patient'));
    }

    /**
     * Update patient profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'birth_date' => 'required|date|before:today',
            'civil_status' => 'required|in:Single,Married,Widowed,Divorced',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            'relationship_to_patient' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('profile.complete')
                ->with('error', 'Patient record not found. Please complete your profile.');
        }

        // Update patient record
        $patient->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'birth_date' => $request->birth_date,
            'civil_status' => $request->civil_status,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'relationship_to_patient' => $request->relationship_to_patient,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
