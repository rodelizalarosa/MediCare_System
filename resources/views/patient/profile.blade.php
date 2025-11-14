@extends('layouts.app')

@section('title', 'Patient Profile')

@php
    $pageTitle = 'Patient Profile';
@endphp

@push('styles')
<style>
    .profile-container {
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .page-header h1 {
        font-family: 'Noto Serif', serif;
        font-size: 2rem;
        color: #1B4D89;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #666;
    }

    .profile-form-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #1B4D89;
    }

    .section-header h2 {
        font-family: 'Noto Serif', serif;
        font-size: 1.4rem;
        color: #1B4D89;
        margin: 0;
    }

    .section-header i {
        font-size: 24px;
        color: #1B4D89;
    }

    /* ====================================== */
    /* FORM GROUPS - UNIFORM WIDTH FIX        */
    /* ====================================== */
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .form-group label i {
        margin-right: 6px;
        color: #1B4D89;
        font-size: 16px;
        vertical-align: middle;
    }

    /* CRITICAL: box-sizing ensures all fields are same width */
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        box-sizing: border-box; /* Include padding and border in width */
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1B4D89;
        box-shadow: 0 0 0 3px rgba(27, 77, 137, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
        line-height: 1.5;
    }

    /* Date input fixes */
    .form-group input[type="date"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .form-group input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.5;
        color: #1B4D89;
    }

    .form-group input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }

    /* Select dropdown wrapper for icon */
    .input-wrapper {
        position: relative;
    }

    .input-wrapper select {
        width: 100%;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding-right: 40px;
        cursor: pointer;
        background-color: white;
    }

    .select-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: #1B4D89;
        pointer-events: none;
    }

    /* Hover effects */
    .form-group input:hover,
    .form-group select:hover,
    .form-group textarea:hover {
        border-color: #1B4D89;
    }

    /* ====================================== */
    /* FORM ACTIONS                           */
    /* ====================================== */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .btn-cancel,
    .btn-save {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-cancel {
        background: #e0e0e0;
        color: #333;
    }

    .btn-cancel:hover {
        background: #d0d0d0;
        transform: translateY(-1px);
    }

    .btn-save {
        background: #F4A700;
        color: #1B4D89;
        font-weight: 700;
    }

    .btn-save:hover {
        background: #d89400;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(244, 167, 0, 0.3);
    }

    .btn-cancel i,
    .btn-save i {
        font-size: 16px;
    }

    /* ====================================== */
    /* ALERTS                                 */
    /* ====================================== */
    .alert {
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* ====================================== */
    /* RESPONSIVE DESIGN                      */
    /* ====================================== */
    @media screen and (max-width: 768px) {
        .profile-container {
            padding: 15px;
        }

        .profile-form-card {
            padding: 20px;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-save {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any client-side validation or enhancements here if needed
    console.log('Profile page loaded');
});
</script>
@endpush

@section('content')
<div class="profile-container">
    <div class="page-header">
        <h1>Patient Profile</h1>
        <p>Update your personal information and emergency contacts</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class='bx bx-check-circle'></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class='bx bx-error-circle'></i> {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('patient.updateProfile') }}" method="POST" class="profile-form-card">
        @csrf
        @method('PUT')

        <!-- Personal Information Section -->
        <div class="section-header">
            <i class='bx bx-user'></i>
            <h2>Personal Information</h2>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="first_name">
                    <i class='bx bx-user-pin'></i> First Name
                </label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
            </div>

            <div class="form-group">
                <label for="middle_name">
                    <i class='bx bx-user-pin'></i> Middle Name
                </label>
                <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name', $patient->middle_name) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="last_name">
                    <i class='bx bx-user-pin'></i> Last Name
                </label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
            </div>

            <div class="form-group">
                <label for="sex">
                    <i class='bx bx-male-female'></i> Sex
                </label>
                <div class="input-wrapper">
                    <select id="sex" name="sex" required>
                        <option value="">Select sex</option>
                        <option value="Male" {{ old('sex', $patient->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex', $patient->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    <i class='bx bx-chevron-down select-icon'></i>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="birth_date">
                    <i class='bx bx-calendar'></i> Birth Date
                </label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->format('Y-m-d') : '') }}" required>
            </div>

            <div class="form-group">
                <label for="civil_status">
                    <i class='bx bx-heart'></i> Civil Status
                </label>
                <div class="input-wrapper">
                    <select id="civil_status" name="civil_status" required>
                        <option value="">Select civil status</option>
                        <option value="Single" {{ old('civil_status', $patient->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('civil_status', $patient->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Widowed" {{ old('civil_status', $patient->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Divorced" {{ old('civil_status', $patient->civil_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                    </select>
                    <i class='bx bx-chevron-down select-icon'></i>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="contact_number">
                    <i class='bx bx-phone'></i> Contact Number
                </label>
                <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number', $patient->contact_number) }}" required>
            </div>

            <div class="form-group">
                <label for="address">
                    <i class='bx bx-map-pin'></i> Address
                </label>
                <textarea id="address" name="address" placeholder="Enter your complete address" required>{{ old('address', $patient->address) }}</textarea>
            </div>
        </div>

        <!-- Emergency Contact Section -->
        <div class="section-header">
            <i class='bx bx-phone-call'></i>
            <h2>Emergency Contact</h2>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="emergency_contact_name">
                    <i class='bx bx-user-check'></i> Emergency Contact Name
                </label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" required>
            </div>

            <div class="form-group">
                <label for="emergency_contact_number">
                    <i class='bx bx-phone'></i> Emergency Contact Number
                </label>
                <input type="tel" id="emergency_contact_number" name="emergency_contact_number" value="{{ old('emergency_contact_number', $patient->emergency_contact_number) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="relationship_to_patient">
                <i class='bx bx-family'></i> Relationship to Patient
            </label>
            <div class="input-wrapper">
                <select id="relationship_to_patient" name="relationship_to_patient" required>
                    <option value="">Select relationship</option>
                    <option value="Spouse" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                    <option value="Parent" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Parent' ? 'selected' : '' }}>Parent</option>
                    <option value="Child" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Child' ? 'selected' : '' }}>Child</option>
                    <option value="Sibling" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                    <option value="Relative" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Relative' ? 'selected' : '' }}>Relative</option>
                    <option value="Friend" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Friend' ? 'selected' : '' }}>Friend</option>
                    <option value="Other" {{ old('relationship_to_patient', $patient->relationship_to_patient) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <i class='bx bx-chevron-down select-icon'></i>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('dashboard.patient') }}" class="btn-cancel">
                <i class='bx bx-x'></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class='bx bx-save'></i> Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
