<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationController;

use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\HomepageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ REGISTER
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//EMAIL VERIFICATION
Route::get('/verify-pin', [EmailVerificationController::class, 'showVerifyPinForm'])->name('verify.pin');

Route::post('/verify-pin', [EmailVerificationController::class, 'verifyPin'])
    ->name('verify.pin');

// ✅ LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


// ✅ LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ✅ PATIENT PROFILE COMPLETION (after email verify)
Route::middleware('auth')->group(function () {

    Route::get('/complete-profile', [PatientProfileController::class, 'showCompleteForm'])->name('profile.complete');
    Route::post('/complete-profile',[PatientProfileController::class, 'saveProfile']);

});


// ✅ PROTECTED ROUTES (PROFILE COMPLETE REQUIRED)
Route::middleware(['auth', 'profile.complete'])->group(function () {

    // Patient Dashboard
    Route::get('/dashboard/patient', function () {return view('patient.dashboard');})->name('dashboard.patient');
    
    // Staff Dashboard (optional)
    Route::get('/dashboard/staff', function () {return view('staff.dashboard');})->name('dashboard.staff');

});

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');

