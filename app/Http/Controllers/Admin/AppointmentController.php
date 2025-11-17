<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApproved;
use App\Mail\AppointmentRejected;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('admin.appointments', compact('appointments'));
    }

    public function approve($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->appointment_status !== 'Pending') {
            return redirect()->route('admin.appointments')->with('error', 'Only pending appointments can be approved.');
        }

        $appointment->update(['appointment_status' => 'Approved']);

        // Send approval email
        try {
            Mail::to($appointment->patient->user->email)->send(new AppointmentApproved($appointment));
        } catch (\Exception $e) {
            // Log the error but don't fail the approval
            \Log::error('Failed to send appointment approval email: ' . $e->getMessage());
        }

        return redirect()->route('admin.appointments')->with('success', 'Appointment approved successfully. Confirmation email sent to patient.');
    }

    public function reject(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->appointment_status !== 'Pending') {
            return redirect()->route('admin.appointments')->with('error', 'Only pending appointments can be rejected.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $appointment->update(['appointment_status' => 'Rejected']);

        // Send rejection email with reason
        try {
            Mail::to($appointment->patient->user->email)->send(new AppointmentRejected($appointment, $request->rejection_reason));
        } catch (\Exception $e) {
            // Log the error but don't fail the rejection
            \Log::error('Failed to send appointment rejection email: ' . $e->getMessage());
        }

        return redirect()->route('admin.appointments')->with('success', 'Appointment rejected successfully. Notification email sent to patient.');
    }

    public function cancel($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->appointment_status !== 'Approved') {
            return redirect()->route('admin.appointments')->with('error', 'Only approved appointments can be cancelled.');
        }

        $appointment->update(['appointment_status' => 'Cancelled']);

        return redirect()->route('admin.appointments')->with('success', 'Appointment cancelled successfully.');
    }

    public function complete($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->appointment_status !== 'Approved') {
            return redirect()->route('admin.appointments')->with('error', 'Only approved appointments can be marked as completed.');
        }

        $appointment->update(['appointment_status' => 'Completed']);

        return redirect()->route('admin.appointments')->with('success', 'Appointment completed successfully.');
    }
}
