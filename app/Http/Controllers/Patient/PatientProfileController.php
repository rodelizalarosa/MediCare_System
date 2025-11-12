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

        // If profile already exists, redirect to dashboard
        if ($user->patient) {
            return redirect()->route('dashboard.patient');
        }

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

        /**
         * Create patient record
         */
        $patient = Patient::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name ?? $user->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name ?? $user->last_name,
            'birth_date' => $request->birth_date,
            'sex' => $request->sex,

            'address' => $request->address,
            'contact_number' => $request->contact_number,

            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'relationship_to_patient' => $request->relationship_to_patient,

            'registration_source' => 'Online',
        ]);

        /**
         * Create empty medical history for this patient
         */
        MedicalHistory::create([
            'patient_id' => $patient->id
        ]);

        return redirect()->route('dashboard.patient')
            ->with('message', 'Your profile has been completed successfully.');
    }
}
