@extends('layouts.app')

@section('title', 'Medical Records')

@php
    $pageTitle = 'Medical Records';
@endphp

@push('styles')
<style>
    .records-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        margin-left: 50px;
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

    .records-section {
        margin-bottom: 40px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #1B4D89;
    }

    .section-header h2 {
        font-family: 'Noto Serif', serif;
        font-size: 1.5rem;
        color: #1B4D89;
        margin: 0;
    }

    .section-header i {
        font-size: 24px;
        color: #1B4D89;
    }

    .record-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        padding: 25px;
        margin-bottom: 20px;
        border-left: 4px solid #1B4D89;
    }

    .record-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .record-item:last-child {
        border-bottom: none;
    }

    .record-label {
        font-weight: 600;
        color: #333;
        min-width: 200px;
    }

    .record-value {
        color: #555;
        flex: 1;
        text-align: right;
    }

    .record-value.empty {
        color: #999;
        font-style: italic;
    }

    .appointment-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid #F4A700;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .appointment-date {
        font-weight: 600;
        color: #1B4D89;
    }

    .appointment-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .appointment-status.pending {
        background: #fff3cd;
        color: #856404;
    }

    .appointment-status.confirmed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .appointment-status.completed {
        background: #d4edda;
        color: #155724;
    }

    .appointment-status.cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .appointment-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
        font-size: 0.9rem;
    }

    .appointment-detail {
        display: flex;
        justify-content: space-between;
    }

    .appointment-detail span:first-child {
        font-weight: 500;
        color: #666;
    }

    .no-records {
        text-align: center;
        padding: 40px;
        color: #666;
        font-style: italic;
    }

    .no-records i {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }

    @media screen and (max-width: 768px) {
        .records-container {
            padding: 15px;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .record-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .record-value {
            text-align: left;
        }

        .appointment-details {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="records-container">
    <div class="page-header">
        <h1>Medical Records</h1>
        <p>View your detailed medical history and appointment records</p>
    </div>

    <!-- Patient Information and Medical History Table -->
    <div class="records-section">
        <div class="section-header">
            <i class='bx bx-health'></i>
            <h2>Patient Information & Medical History</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Field</th>
                        <th>Information</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Patient Information -->
                    <tr>
                        <td><strong>Full Name</strong></td>
                        <td>{{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Sex</strong></td>
                        <td>{{ $patient->sex }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date of Birth</strong></td>
                        <td>{{ \Carbon\Carbon::parse($patient->birth_date)->format('F j, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Civil Status</strong></td>
                        <td>{{ $patient->civil_status }}</td>
                    </tr>
                    <tr>
                        <td><strong>Contact Number</strong></td>
                        <td>{{ $patient->contact_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td>
                        <td>{{ $patient->address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Emergency Contact Name</strong></td>
                        <td>{{ $patient->emergency_contact_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Emergency Contact Number</strong></td>
                        <td>{{ $patient->emergency_contact_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Relationship to Patient</strong></td>
                        <td>{{ $patient->relationship_to_patient }}</td>
                    </tr>

                    <!-- Medical History -->
                    @if($medicalHistory)
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Medical History</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Known Conditions</strong></td>
                        <td>{{ $medicalHistory->known_conditions ?? 'No known conditions recorded' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Allergies</strong></td>
                        <td>{{ $medicalHistory->allergies ?? 'No allergies recorded' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Current Medications</strong></td>
                        <td>{{ $medicalHistory->current_medications ?? 'No current medications' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Previous Hospitalizations</strong></td>
                        <td>{{ $medicalHistory->previous_hospitalization ?? 'No previous hospitalizations' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Family History</strong></td>
                        <td>{{ $medicalHistory->family_history ?? 'No family history recorded' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Immunization Status</strong></td>
                        <td>{{ $medicalHistory->immunization_status ?? 'Incomplete' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Additional Remarks</strong></td>
                        <td>{{ $medicalHistory->remarks ?? 'No additional remarks' }}</td>
                    </tr>
                    @else
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Medical History</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center text-muted">No medical history records found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Appointment History Section -->
    <div class="records-section">
        <div class="section-header">
            <i class='bx bx-calendar-check'></i>
            <h2>Appointment History</h2>
        </div>

        @if($appointments && $appointments->count() > 0)
            @foreach($appointments as $appointment)
            <div class="appointment-item">
                <div class="appointment-header">
                    <span class="appointment-date">
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                    </span>
                    <span class="appointment-status {{ $appointment->appointment_status }}">
                        {{ ucfirst($appointment->appointment_status) }}
                    </span>
                </div>
                <div class="appointment-details">
                    <div class="appointment-detail">
                        <span>Type:</span>
                        <span>{{ ucfirst($appointment->appointment_type) }}</span>
                    </div>
                    <div class="appointment-detail">
                        <span>Reason:</span>
                        <span>{{ $appointment->remarks ?? 'N/A' }}</span>
                    </div>
                    @if($appointment->staff)
                    <div class="appointment-detail">
                        <span>Healthcare Provider:</span>
                        <span>{{ $appointment->staff->name ?? 'Not assigned' }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        @else
        <div class="no-records">
            <i class='bx bx-calendar-x'></i>
            <p>No appointment records found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
