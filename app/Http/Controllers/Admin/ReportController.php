<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Staff;
use App\Models\Doctor;
use App\Models\Midwife;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        // Get patient summary
        $totalPatients = Patient::count();
        $activePatients = Patient::where('record_status', 'active')->count();
        $inactivePatients = Patient::where('record_status', 'inactive')->count();

        // Get appointment summary
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('appointment_status', 'Pending')->count();
        $approvedAppointments = Appointment::where('appointment_status', 'Approved')->count();
        $completedAppointments = Appointment::where('appointment_status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('appointment_status', 'Cancelled')->count();
        $rejectedAppointments = Appointment::where('appointment_status', 'Rejected')->count();

        // Get staff summary
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();
        $totalMidwives = Midwife::count();

        return view('admin.reports', compact(
            'totalPatients',
            'activePatients',
            'inactivePatients',
            'totalAppointments',
            'pendingAppointments',
            'approvedAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'rejectedAppointments',
            'totalStaff',
            'totalDoctors',
            'totalMidwives'
        ));
    }

    public function generatePDF()
    {
        // Get patient summary
        $totalPatients = Patient::count();
        $activePatients = Patient::where('record_status', 'active')->count();
        $inactivePatients = Patient::where('record_status', 'inactive')->count();

        // Get appointment summary
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('appointment_status', 'Pending')->count();
        $approvedAppointments = Appointment::where('appointment_status', 'Approved')->count();
        $completedAppointments = Appointment::where('appointment_status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('appointment_status', 'Cancelled')->count();
        $rejectedAppointments = Appointment::where('appointment_status', 'Rejected')->count();

        // Get staff summary
        $totalStaff = Staff::count();
        $totalDoctors = Doctor::count();
        $totalMidwives = Midwife::count();

        $data = [
            'totalPatients' => $totalPatients,
            'activePatients' => $activePatients,
            'inactivePatients' => $inactivePatients,
            'totalAppointments' => $totalAppointments,
            'pendingAppointments' => $pendingAppointments,
            'approvedAppointments' => $approvedAppointments,
            'completedAppointments' => $completedAppointments,
            'cancelledAppointments' => $cancelledAppointments,
            'rejectedAppointments' => $rejectedAppointments,
            'totalStaff' => $totalStaff,
            'totalDoctors' => $totalDoctors,
            'totalMidwives' => $totalMidwives,
            'generatedAt' => now()->format('F j, Y \a\t g:i A')
        ];

        $pdf = PDF::loadView('admin.reports-pdf', $data);

        return $pdf->download('mediCare-reports-' . now()->format('Y-m-d') . '.pdf');
    }
}
