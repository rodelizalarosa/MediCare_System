@extends('layouts.app') {{-- This uses your default layout (with sidebar + header) --}}

@section('title', 'Complete Your Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/complete-profile.css') }}">
@endpush

@section('content')
<div class="card">
        <h2 class="card-title">Complete Your Profile</h2>
        <p class="subtitle">Please fill in the remaining information to complete your registration.</p>

        @if(session('message'))
            <div class="alert success">{{ session('message') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('patient.saveProfile') }}" method="POST" class="profile-form">
            @csrf

            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-group">
                    <label for="address">Complete Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required>
                </div>
            </div>

            <div class="form-section">
                <h3>Emergency Contact Information</h3>
                <div class="form-group">
                    <label for="emergency_contact_name">Contact Person</label>
                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required>
                </div>

                <div class="form-group">
                    <label for="emergency_contact_number">Contact Number</label>
                    <input type="text" name="emergency_contact_number" id="emergency_contact_number" value="{{ old('emergency_contact_number') }}" required>
                </div>

                <div class="form-group">
                    <label for="relationship_to_patient">Relationship to Patient</label>
                    <div class="input-wrapper">
                        <select name="relationship_to_patient" id="relationship_to_patient" required>
                            <option value="">Select relationship</option>
                            <option value="Spouse" {{ old('relationship_to_patient') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                            <option value="Parent" {{ old('relationship_to_patient') == 'Parent' ? 'selected' : '' }}>Parent</option>
                            <option value="Child" {{ old('relationship_to_patient') == 'Child' ? 'selected' : '' }}>Child</option>
                            <option value="Sibling" {{ old('relationship_to_patient') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                            <option value="Relative" {{ old('relationship_to_patient') == 'Relative' ? 'selected' : '' }}>Relative</option>
                            <option value="Friend" {{ old('relationship_to_patient') == 'Friend' ? 'selected' : '' }}>Friend</option>
                            <option value="Other" {{ old('relationship_to_patient') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <i class='bx bx-chevron-down select-icon'></i>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Save Profile</button>
            </div>
        </form>
    </div>
@endsection
