@extends('layouts.app')

@section('title', 'Book Appointment')

@php
    $pageTitle = 'Book Appointment';
@endphp

@push('styles')
<style>
    .appointments-container {
        padding: 20px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-family: 'Noto Serif', serif;
        font-size: 2rem;
        color: #1B4D89;
        margin-bottom: 10px;
        text-align: center;
    }

    .page-header p {
        color: #666;
        text-align: center;
    }

    .appointment-form-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    /* ====================================== */
    /* FORM GROUPS - UNIFORM WIDTH FIX        */
    /* ====================================== */
    .form-group {
        margin-bottom: 20px;
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
    .form-group textarea,
    .form-group select {
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
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1B4D89;
        box-shadow: 0 0 0 3px rgba(27, 77, 137, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.5;
    }

    /* Date and Time input fixes */
    .form-group input[type="date"],
    .form-group input[type="time"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .form-group input[type="date"]::-webkit-calendar-picker-indicator,
    .form-group input[type="time"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.5;
        color: #1B4D89;
    }

    .form-group input[type="date"]::-webkit-calendar-picker-indicator:hover,
    .form-group input[type="time"]::-webkit-calendar-picker-indicator:hover {
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
    .form-group textarea:hover,
    .form-group select:hover {
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
    .btn-submit {
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

    .btn-submit {
        background: #F4A700;
        color: #1B4D89;
        font-weight: 700;
    }

    .btn-submit:hover {
        background: #d89400;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(244, 167, 0, 0.3);
    }

    .btn-cancel i,
    .btn-submit i {
        font-size: 16px;
    }

    /* ====================================== */
    /* ALERTS & SCHEDULE INFO                 */
    /* ====================================== */
    .alert {
        padding: 12px 20px;
        margin-top:20px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .schedule-info {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .schedule-info h4 {
        margin: 0 0 10px 0;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .schedule-info h4 i {
        font-size: 18px;
    }

    .schedule-info ul {
        margin: 0;
        padding-left: 20px;
    }

    .schedule-info li {
        margin-bottom: 5px;
    }

    /* ====================================== */
    /* RESPONSIVE DESIGN                      */
    /* ====================================== */
    @media screen and (max-width: 768px) {
        .appointments-container {
            padding: 15px;
        }

        .appointment-form-card {
            padding: 20px;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const appointmentTypeSelect = document.getElementById('appointment_type');
    const dateInput = document.getElementById('preferred_date');
    const scheduleInfo = document.createElement('div');
    scheduleInfo.className = 'schedule-info';
    scheduleInfo.innerHTML = `
        <h4><i class='bx bx-info-circle'></i> Available Schedule</h4>
        <ul>
            <li><strong>Doctors:</strong> Tuesday, Thursday</li>
            <li><strong>Midwives:</strong> Monday, Wednesday, Friday</li>
            <li><strong>Health Workers:</strong> Monday to Sunday</li>
        </ul>
    `;

    // Insert schedule info after the appointment type wrapper
    const appointmentTypeWrapper = appointmentTypeSelect.closest('.form-group').querySelector('.input-wrapper');
    appointmentTypeWrapper.insertAdjacentElement('afterend', scheduleInfo);

    function updateAvailableDates() {
        const selectedType = appointmentTypeSelect.value;
        const today = new Date();
        const currentDate = new Date(today);

        // Clear existing restrictions
        dateInput.setAttribute('min', today.toISOString().split('T')[0]);

        if (selectedType === 'Doctor Consultation') {
            // Doctors: Tuesday (2), Thursday (4)
            const availableDates = [];
            for (let i = 0; i < 30; i++) {
                const date = new Date(currentDate);
                date.setDate(currentDate.getDate() + i);
                const dayOfWeek = date.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
                if (dayOfWeek === 2 || dayOfWeek === 4) { // Tuesday or Thursday
                    availableDates.push(date.toISOString().split('T')[0]);
                }
            }
            console.log('Available dates for doctors:', availableDates);
        } else if (selectedType === 'Midwife Consultation') {
            // Midwives: Monday (1), Wednesday (3), Friday (5)
            const availableDates = [];
            for (let i = 0; i < 30; i++) {
                const date = new Date(currentDate);
                date.setDate(currentDate.getDate() + i);
                const dayOfWeek = date.getDay();
                if (dayOfWeek === 1 || dayOfWeek === 3 || dayOfWeek === 5) { // Monday, Wednesday, Friday
                    availableDates.push(date.toISOString().split('T')[0]);
                }
            }
            console.log('Available dates for midwives:', availableDates);
        }
        // For other types (General Check-up, Maternal Check-up, Vaccination), all days are available
    }

    appointmentTypeSelect.addEventListener('change', updateAvailableDates);
    updateAvailableDates(); // Initial call
});
</script>
@endpush

@section('content')
<div class="appointments-container">
    <div class="page-header">
        <h1>Book an Appointment</h1>
        <p>Schedule your appointment with our healthcare providers</p>
    </div>

    <div class="appointment-form-card">
        <form action="{{ route('patient.storeAppointment') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="appointment_type">
                    <i class='bx bx-clinic'></i> Appointment Type
                </label>
                <div class="input-wrapper">
                    <select id="appointment_type" name="appointment_type" required>
                        <option value="">Select appointment type</option>
                        <option value="General Check-up">General Check-up</option>
                        <option value="Maternal Check-up">Maternal Check-up</option>
                        <option value="Vaccination">Vaccination</option>
                        <option value="Doctor Consultation">Doctor Consultation</option>
                        <option value="Midwife Consultation">Midwife Consultation</option>
                    </select>
                    <i class='bx bx-chevron-down select-icon'></i>
                </div>
            </div>

            <div class="form-group">
                <label for="preferred_date">
                    <i class='bx bx-calendar'></i> Preferred Date
                </label>
                <input type="date" id="preferred_date" name="preferred_date" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label for="preferred_time">
                    <i class='bx bx-time'></i> Preferred Time
                </label>
                <input type="time" id="preferred_time" name="preferred_time" required>
            </div>

            <div class="form-group">
                <label for="reason">
                    <i class='bx bx-message-square-detail'></i> Reason for Visit
                </label>
                <textarea id="reason" name="reason" placeholder="Please describe the reason for your appointment" required></textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.patient') }}" class="btn-cancel">
                    <i class='bx bx-x'></i> Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-check'></i> Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection