<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationController;

use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Patient\DashboardController;
use App\Http\Controllers\HomepageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ REGISTER
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// EMAIL VERIFICATION
Route::get('/verify-pin', [EmailVerificationController::class, 'showPinForm'])
    ->name('verify.pin.form'); // ✅ fix this

Route::post('/verify-pin', [EmailVerificationController::class, 'verifyPin'])
    ->name('verify.pin');

Route::post('/resend-pin', [EmailVerificationController::class, 'resendPin'])
    ->name('resend.pin');

// ✅ LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


// ✅ LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ✅ PATIENT PROFILE COMPLETION (after email verify)
Route::middleware('auth')->group(function () {

    Route::get('/complete-profile', [PatientProfileController::class, 'showCompleteForm'])->name('profile.complete');
    Route::post('/complete-profile',[PatientProfileController::class, 'saveProfile'])->name('patient.saveProfile');

});


// ✅ PROTECTED ROUTES (PROFILE COMPLETE REQUIRED)
Route::middleware(['auth', 'profile.complete'])->group(function () {

    // Patient Dashboard
    Route::get('/dashboard/patient', [DashboardController::class, 'index'])->name('dashboard.patient');
    Route::post('/dashboard/patient/medical-history', [DashboardController::class, 'storeMedicalHistory'])->name('patient.storeMedicalHistory');

    // Patient Appointments
    Route::get('/appointments', function () {
        return view('patient.appointments');
    })->name('patient.appointments');
    Route::get('/patient/appointments/{appointment}', [DashboardController::class, 'showAppointment'])->name('patient.showAppointment');
    Route::post('/appointments', [DashboardController::class, 'storeAppointment'])->name('patient.storeAppointment');

    // Patient Profile and Records
    Route::get('/patient/profile', [PatientProfileController::class, 'showProfile'])->name('patient.profile');
    Route::put('/patient/profile', [PatientProfileController::class, 'updateProfile'])->name('patient.updateProfile');
    Route::get('/patient/records', function () {
        $user = Auth::user();
        $patient = $user->patient;
        $medicalHistory = $patient->medicalHistory;
        $appointments = $patient->appointments()->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc')->get();
        return view('patient.records', compact('patient', 'medicalHistory', 'appointments'));
    })->name('patient.records');

    // Admin Dashboard
    Route::get('/dashboard/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/staff', function () {return view('dashboard.admin-index');})->name('dashboard.staff');
    Route::get('/admin/patients', function (\Illuminate\Http\Request $request) {
        if ($request->ajax() && $request->has('patient') && $request->action === 'view') {
            $patient = \App\Models\Patient::with('medicalHistory')->findOrFail($request->patient);
            return response()->json([
                'patient' => $patient,
                'medicalHistory' => $patient->medicalHistory
            ]);
        }

        $patients = \App\Models\Patient::all();
        return view('admin.patients', compact('patients'));
    })->name('admin.patients');

    Route::post('/admin/patients/{patient}', function (\Illuminate\Http\Request $request, $patientId) {
        try {
            $patient = \App\Models\Patient::findOrFail($patientId);

            // Update patient data
            $patient->update($request->only([
                'first_name', 'middle_name', 'last_name', 'sex', 'birth_date',
                'civil_status', 'contact_number', 'address', 'emergency_contact_name',
                'emergency_contact_number', 'relationship_to_patient'
            ]));

            // Update or create medical history
            $medicalHistory = $patient->medicalHistory ?? new \App\Models\MedicalHistory(['patient_id' => $patientId]);
            $medicalHistory->fill($request->only([
                'known_conditions', 'allergies', 'current_medications',
                'previous_hospitalizations', 'family_history', 'immunization_status', 'remarks'
            ]));
            $medicalHistory->save();

            return response()->json(['success' => true, 'message' => 'Patient updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    })->name('admin.patients.update');
    Route::get('/admin/appointments', [App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('admin.appointments');
    Route::post('/admin/appointments/{appointmentId}/approve', [App\Http\Controllers\Admin\AppointmentController::class, 'approve'])->name('admin.appointments.approve');
    Route::post('/admin/appointments/{appointmentId}/reject', [App\Http\Controllers\Admin\AppointmentController::class, 'reject'])->name('admin.appointments.reject');
    Route::post('/admin/appointments/{appointmentId}/cancel', [App\Http\Controllers\Admin\AppointmentController::class, 'cancel'])->name('admin.appointments.cancel');
    Route::post('/admin/appointments/{appointmentId}/complete', [App\Http\Controllers\Admin\AppointmentController::class, 'complete'])->name('admin.appointments.complete');
    Route::get('/admin/medical-history', function () {return view('admin.medical-history');})->name('admin.medical-history');
    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
    Route::get('/admin/reports/generate-pdf', [App\Http\Controllers\Admin\ReportController::class, 'generatePDF'])->name('admin.reports.generate-pdf');
    Route::get('/admin/staff', [App\Http\Controllers\Admin\StaffController::class, 'index'])->name('admin.staff');
    Route::get('/admin/staff/create', [App\Http\Controllers\Admin\StaffController::class, 'create'])->name('admin.staff.create');
    Route::post('/admin/staff', [App\Http\Controllers\Admin\StaffController::class, 'store'])->name('admin.staff.store');
    Route::get('/admin/staff/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'showStaff'])->name('admin.staff.show');
    Route::post('/admin/staff/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'updateStaff'])->name('admin.staff.update');
    Route::get('/admin/doctors', [App\Http\Controllers\Admin\StaffController::class, 'doctors'])->name('admin.doctors');
    Route::get('/admin/doctors/create', [App\Http\Controllers\Admin\StaffController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/admin/doctors', [App\Http\Controllers\Admin\StaffController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/admin/doctors/{doctor}', [App\Http\Controllers\Admin\StaffController::class, 'showDoctor'])->name('admin.doctors.show');
    Route::post('/admin/doctors/{doctor}', [App\Http\Controllers\Admin\StaffController::class, 'updateDoctor'])->name('admin.doctors.update');
    Route::get('/admin/midwives', [App\Http\Controllers\Admin\StaffController::class, 'midwives'])->name('admin.midwives');
    Route::get('/admin/midwives/create', [App\Http\Controllers\Admin\StaffController::class, 'createMidwife'])->name('admin.midwives.create');
    Route::post('/admin/midwives', [App\Http\Controllers\Admin\StaffController::class, 'storeMidwife'])->name('admin.midwives.store');
    Route::get('/admin/midwives/{midwife}', [App\Http\Controllers\Admin\StaffController::class, 'showMidwife'])->name('admin.midwives.show');
    Route::post('/admin/midwives/{midwife}', [App\Http\Controllers\Admin\StaffController::class, 'updateMidwife'])->name('admin.midwives.update');
    Route::get('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'showProfile'])->name('admin.profile');
    Route::put('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/notifications', function () {return view('admin.notifications');})->name('admin.notifications');

});

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
