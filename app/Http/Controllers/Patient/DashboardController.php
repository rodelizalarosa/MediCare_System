<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;

        // Check if patient exists
        if (!$patient) {
            return redirect()->route('profile.complete')
                ->with('error', 'Patient record not found. Please complete your profile.');
        }

        // Get or create medical history for the patient
        $medicalHistory = MedicalHistory::where('patient_id', $patient->id)->first();
        
        // If no medical history exists, create an empty one
        if (!$medicalHistory) {
            $medicalHistory = MedicalHistory::create([
                'patient_id' => $patient->id
            ]);
        }

        // Get upcoming appointments for the patient
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now()->toDateString())
            ->where('appointment_status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get()
            ->map(function ($appointment) {
                return [
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'type' => ucfirst($appointment->appointment_type),
                    'status' => ucfirst($appointment->appointment_status),
                ];
            });

        return view('dashboard.patient-index', compact('medicalHistory', 'upcomingAppointments'));
    }

    public function storeMedicalHistory(Request $request)
    {
        $request->validate([
            'known_conditions' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'previous_hospitalization' => 'nullable|string',
            'family_history' => 'nullable|string',
            'immunization_status' => 'nullable|in:Complete,Incomplete',
            'remarks' => 'nullable|string',
        ]);

        $user = Auth::user();
        $patient = $user->patient;

        // Check if patient exists
        if (!$patient) {
            return redirect()->route('profile.complete')
                ->with('error', 'Patient record not found. Please complete your profile.');
        }

        // Update or create medical history
        $medicalHistory = MedicalHistory::where('patient_id', $patient->id)->first();

        if ($medicalHistory) {
            $medicalHistory->update([
                'known_conditions' => $request->known_conditions,
                'allergies' => $request->allergies,
                'current_medications' => $request->current_medications,
                'previous_hospitalization' => $request->previous_hospitalization,
                'family_history' => $request->family_history,
                'immunization_status' => $request->immunization_status ?? 'Incomplete',
                'remarks' => $request->remarks,
            ]);
        } else {
            MedicalHistory::create([
                'patient_id' => $patient->id,
                'known_conditions' => $request->known_conditions,
                'allergies' => $request->allergies,
                'current_medications' => $request->current_medications,
                'previous_hospitalization' => $request->previous_hospitalization,
                'family_history' => $request->family_history,
                'immunization_status' => $request->immunization_status ?? 'Incomplete',
                'remarks' => $request->remarks,
            ]);
        }

        return redirect()->back()->with('success', 'Medical history saved successfully.');
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'appointment_type' => 'required|in:General Check-up,Maternal Check-up,Vaccination,Doctor Consultation,Midwife Consultation',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $patient = $user->patient;

        // Check if patient exists
        if (!$patient) {
            return redirect()->route('profile.complete')
                ->with('error', 'Patient record not found. Please complete your profile.');
        }

        // Create the appointment
        Appointment::create([
            'patient_id' => $patient->id,
            'appointment_type' => $request->appointment_type,
            'appointment_date' => $request->preferred_date,
            'appointment_time' => $request->preferred_time,
            'appointment_status' => 'pending', // Default status
            'remarks' => $request->reason,
        ]);

        return redirect()->route('dashboard.patient')->with('success', 'Appointment booked successfully! We will confirm your appointment soon.');
    }
}
