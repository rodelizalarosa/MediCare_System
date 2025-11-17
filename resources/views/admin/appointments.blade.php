@extends('layouts.app')

@php
    $pageTitle = 'Appointments';
@endphp

@section('title', 'Admin - Appointments')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .appointments-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .appointments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .appointments-title {
        font-family: 'Noto Serif', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #1B4D89;
        margin: 0;
    }

    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .appointments-table th,
    .appointments-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .appointments-table th {
        background: #1B4D89;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .appointments-table tr:hover {
        background: #f8f9fa;
    }

    .patient-link {
        color: #1B4D89;
        text-decoration: none;
        font-weight: 500;
    }

    .patient-link:hover {
        text-decoration: underline;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
    }

    .status-rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .status-completed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-cancelled {
        background: #e2e3e5;
        color: #383d41;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-approve {
        background: #28a745;
        color: white;
    }

    .btn-approve:hover {
        background: #218838;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
    }

    .btn-reject:hover {
        background: #c82333;
    }

    .btn-cancel {
        background: #ffc107;
        color: #212529;
    }

    .btn-cancel:hover {
        background: #e0a800;
    }

    .btn-complete {
        background: #17a2b8;
        color: white;
    }

    .btn-complete:hover {
        background: #138496;
    }

    .btn-disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .no-appointments {
        text-align: center;
        padding: 50px;
        color: #999;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .appointments-container {
            padding: 10px;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 10px 5px;
            font-size: 0.8rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            padding: 4px 8px;
            font-size: 0.7rem;
        }
    }
</style>
@endpush

@section('content')
<div class="appointments-container">
    <div class="appointments-header">
        <h1 class="appointments-title">All Appointments</h1>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px 20px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if(isset($appointments) && $appointments->count() > 0)
        <div style="overflow-x: auto;">
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Appointment #</th>
                        <th>Patient Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_id }}</td>
                            <td>
                                <a href="{{ route('admin.patients') }}?patient={{ $appointment->patient_id }}" class="patient-link">
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                </a>
                            </td>
                            <td>{{ $appointment->appointment_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
                            <td>{{ $appointment->remarks ?: 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($appointment->appointment_status) }}">
                                    {{ $appointment->appointment_status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($appointment->appointment_status === 'Pending')
                                        <button type="button" class="btn-action btn-approve" onclick="openApproveModal({{ $appointment->appointment_id }}, '{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}', '{{ $appointment->appointment_type }}', '{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}', '{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}')">✓</button>
                                        <button type="button" class="btn-action btn-reject" onclick="openRejectModal({{ $appointment->appointment_id }}, '{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}')">✗</button>
                                    @elseif($appointment->appointment_status === 'Approved')
                                        <form method="POST" action="{{ route('admin.appointments.complete', $appointment->appointment_id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-complete">Complete</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.appointments.cancel', $appointment->appointment_id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-cancel">Cancel</button>
                                        </form>
                                    @else
                                        <span style="color: #999; font-size: 0.8rem;">No actions available</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-appointments">
            <p>No appointments found.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function openApproveModal(appointmentId, patientName, appointmentType, date, time) {
    // Create modal HTML
    const modalHtml = `
        <div id="approveModal" class="modal" style="display: block; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px;">
                <span class="close" onclick="closeModal()" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                <h2 style="color: #1B4D89; margin-bottom: 20px;">Confirm Appointment Approval</h2>
                <p><strong>Patient:</strong> ${patientName}</p>
                <p><strong>Type:</strong> ${appointmentType}</p>
                <p><strong>Date:</strong> ${date}</p>
                <p><strong>Time:</strong> ${time}</p>
                <p style="margin-top: 20px;">Are you sure you want to approve this appointment? An approval email will be sent to the patient.</p>
                <div style="text-align: right; margin-top: 20px;">
                    <button onclick="closeModal()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-right: 10px;">Cancel</button>
                    <form method="POST" action="{{ route('admin.appointments.approve', ':appointmentId') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="appointment_id" value="${appointmentId}">
                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    `;

    // Replace placeholder in form action
    const finalModalHtml = modalHtml.replace(':appointmentId', appointmentId);

    // Append modal to body
    document.body.insertAdjacentHTML('beforeend', finalModalHtml);
}

function openRejectModal(appointmentId, patientName) {
    // Create modal HTML
    const modalHtml = `
        <div id="rejectModal" class="modal" style="display: block; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px;">
                <span class="close" onclick="closeModal()" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                <h2 style="color: #1B4D89; margin-bottom: 20px;">Reject Appointment</h2>
                <p><strong>Patient:</strong> ${patientName}</p>
                <form method="POST" action="{{ route('admin.appointments.reject', ':appointmentId') }}">
                    @csrf
                    <input type="hidden" name="appointment_id" value="${appointmentId}">
                    <div style="margin-bottom: 15px;">
                        <label for="rejection_reason" style="display: block; margin-bottom: 5px; font-weight: bold;">Reason for Rejection:</label>
                        <textarea id="rejection_reason" name="rejection_reason" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; min-height: 80px; box-sizing: border-box;" placeholder="Please provide a reason for rejecting this appointment..."></textarea>
                    </div>
                    <div style="text-align: right; margin-top: 20px;">
                        <button type="button" onclick="closeModal()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-right: 10px;">Cancel</button>
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Reject & Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    `;

    // Replace placeholder in form action
    const finalModalHtml = modalHtml.replace(':appointmentId', appointmentId);

    // Append modal to body
    document.body.insertAdjacentHTML('beforeend', finalModalHtml);
}

function closeModal() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => modal.remove());
}
</script>
@endpush
