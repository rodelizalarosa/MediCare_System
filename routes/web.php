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
    Route::post('/appointments', [DashboardController::class, 'storeAppointment'])->name('patient.storeAppointment');

    // Patient Profile and Records
    Route::get('/patient/profile', [PatientProfileController::class, 'showProfile'])->name('patient.profile');
    Route::put('/patient/profile', [PatientProfileController::class, 'updateProfile'])->name('patient.updateProfile');
    Route::get('/patient/records', function () {
        $user = Auth::user();
        $patient = $user->patient;
        $medicalHistory = $patient->medicalHistory;
        $appointments = $patient->appointments()->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc')->get();
        return view('patient.records', compact('medicalHistory', 'appointments'));
    })->name('patient.records');

    // Staff Dashboard (optional)
    Route::get('/dashboard/staff', function () {return view('staff.dashboard');})->name('dashboard.staff');

});

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
