<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Patients
        $totalPatients = Patient::count();

        // Total Appointments (Pending, Approved, Completed) excluding Rejected and Cancelled
        $totalAppointments = Appointment::whereIn('appointment_status', ['Pending', 'Approved', 'Completed'])->count();

        // Pending Appointments (only pending)
        $pendingAppointments = Appointment::where('appointment_status', 'Pending')->count();

        // Today's Appointments (if dated today)
        $today = Carbon::today()->toDateString();
        $todayAppointments = Appointment::where('appointment_date', $today)->count();

        // Recent Appointments (last 5)
        $recentAppointments = Appointment::with('patient')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent Patients (last 5)
        $recentPatients = Patient::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.admin-index', compact(
            'totalPatients',
            'totalAppointments',
            'pendingAppointments',
            'todayAppointments',
            'recentAppointments',
            'recentPatients'
        ));
    }
}
