@extends('layouts.app')

@section('title', 'Patient Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .dashboard-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    @media (max-width: 968px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    .dashboard-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        padding: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-title {
        font-family: 'Noto Serif', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: #1B4D89;
        margin: 0;
    }

    .btn-action {
        background: #F4A700;
        color: #1B4D89;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action:hover {
        background: #d89400;
        transform: translateY(-1px);
    }

    .btn-action i {
        font-size: 18px;
    }

    .appointment-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 12px;
        border-left: 4px solid #1B4D89;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .appointment-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .appointment-item:last-child {
        margin-bottom: 0;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .appointment-date {
        font-weight: 600;
        color: #1B4D89;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-completed {
        background: #cce5ff;
        color: #004085;
        border: 1px solid #b3d7ff;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .appointment-type {
        color: #666;
        font-size: 0.9rem;
    }

    .no-data {
        text-align: center;
        padding: 30px;
        color: #999;
        font-style: italic;
    }

   /* Medical History Summary */
.medical-history-summary {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px; /* Space for scrollbar */
}

/* Custom scrollbar for medical history */
.medical-history-summary::-webkit-scrollbar {
    width: 6px;
}

.medical-history-summary::-webkit-scrollbar-track {
    background: #f0f0f5;
    border-radius: 10px;
}

.medical-history-summary::-webkit-scrollbar-thumb {
    background-color: #1B4D89;
    border-radius: 10px;
}

.history-section {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.history-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.history-label {
    font-weight: 600;
    color: #1B4D89;
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.history-value {
    color: #333;
    line-height: 1.6;
}

.history-value.empty {
    color: #999;
    font-style: italic;
}

/* Book Appointment Button */
.book-appointment-section {
    text-align: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #1B4D89 0%, #163B6C 100%);
    border-radius: 12px;
    margin-top: 15px;
    margin-bottom: 15px;
}

.btn-book-appointment {
    background: #F4A700;
    color: #1B4D89;
    padding: 18px 40px;
    border-radius: 10px;
    font-size: 1.2rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(244, 167, 0, 0.3);
}

.btn-book-appointment:hover {
    background: #d89400;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(244, 167, 0, 0.4);
    color: #1B4D89;
}

.btn-book-appointment i {
    font-size: 24px;
}

/* ========================================= */
/* FLOATING MODAL - SCROLLABLE FIX          */
/* ========================================= */

.floating-modal {
    display: none;
    position: fixed;
    z-index: 10001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease;
    padding: 20px; /* Add padding for mobile spacing */
}

.floating-modal.active {
    display: flex;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* CRITICAL FIX: Flexbox structure for scrollable body */
.floating-modal-content {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh; /* Increased from 85vh */
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    animation: slideUp 0.3s ease;
    overflow: hidden; /* Prevent outer scroll */
}

@keyframes slideUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Header stays fixed at top */
.floating-modal-header {
    padding: 25px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #1B4D89;
    border-radius: 16px 16px 0 0;
    flex-shrink: 0; /* Prevent shrinking */
}

.floating-modal-header h3 {
    margin: 0;
    color: white;
    font-family: 'Noto Serif', serif;
    font-size: 1.5rem;
}

.floating-modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 28px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.3s;
}

.floating-modal-close:hover {
    background: rgba(255,255,255,0.2);
}

/* Body is scrollable */
.floating-modal-body {
    padding: 25px;
    height: 400px;
    overflow-y: auto; /* Enable scrolling */
    flex: none;
}

/* Custom scrollbar styling */
.floating-modal-body::-webkit-scrollbar {
    width: 8px;
}

.floating-modal-body::-webkit-scrollbar-track {
    background: #f0f0f5;
    border-radius: 10px;
}

.floating-modal-body::-webkit-scrollbar-thumb {
    background-color: #1B4D89;
    border-radius: 10px;
    border: 2px solid #f0f0f5;
}

.floating-modal-body::-webkit-scrollbar-thumb:hover {
    background-color: #163B6C;
}

/* Firefox scrollbar */
.floating-modal-body {
    scrollbar-width: thin;
    scrollbar-color: #1B4D89 #f0f0f5;
}

/* Form groups */
.form-group {
    margin-bottom: 20px;
}

.form-group:last-child {
    margin-bottom: 0; /* Remove margin from last element */
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 0.95rem;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    transition: border-color 0.3s;
    box-sizing: border-box;
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
}

/* Footer stays fixed at bottom */
.floating-modal-footer {
    padding: 20px 25px;
    border-top: 2px solid #f0f0f0;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    flex-shrink: 0; /* Prevent shrinking */
    background: white; /* Ensure solid background */
}

.center-footer {
    justify-content: center;
}

.btn-cancel {
    background: #e0e0e0;
    color: #333;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s;
}

.btn-cancel:hover {
    background: #d0d0d0;
}

.btn-save {
    background: #F4A700;
    color: #1B4D89;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    transition: all 0.3s;
}

.btn-save:hover {
    background: #d89400;
    transform: translateY(-1px);
}

/* ========================================= */
/* RESPONSIVE DESIGN                         */
/* ========================================= */

@media screen and (max-width: 768px) {
    .floating-modal {
        padding: 10px;
    }
    
    .floating-modal-content {
        width: 95%;
        max-height: 95vh;
    }
    
    .floating-modal-header {
        padding: 20px;
    }
    
    .floating-modal-header h3 {
        font-size: 1.25rem;
    }
    
    .floating-modal-body {
        padding: 20px;
    }
    
    .floating-modal-footer {
        padding: 15px 20px;
        flex-direction: column;
    }
    
    .btn-cancel,
    .btn-save {
        width: 100%;
        padding: 14px;
    }
}
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
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Book Appointment Section -->
    <div class="book-appointment-section">
        <a href="#" class="btn-book-appointment" onclick="bookAppointment()">
            <i class='bx bx-calendar-plus'></i>
            Book an Appointment Now
        </a>
    </div>

    <div class="dashboard-grid">
        <!-- Upcoming Appointments Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Upcoming Appointments</h2>
            </div>
            <div class="card-body">
                @if(count($upcomingAppointments) > 0)
                    @foreach($upcomingAppointments as $appointment)
                        <div class="appointment-item" onclick="viewAppointmentDetails({{ $appointment['id'] }})">
                            <div class="appointment-header">
                                <div class="appointment-date">
                                    <i class='bx bx-calendar'></i> {{ $appointment['date'] }}
                                </div>
                                <span class="status-badge status-{{ strtolower($appointment['status']) }}">
                                    {{ $appointment['status'] }}
                                </span>
                            </div>
                            <div class="appointment-type">
                                <i class='bx bx-time'></i> {{ $appointment['time'] }} - {{ $appointment['type'] }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-data">
                        <i class='bx bx-calendar-x' style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                        <p>No upcoming appointments scheduled.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Medical History Summary Card -->
        <div class="dashboard-card medical-history-card">
            <div class="card-header">
                <h2 class="card-title">Medical History Summary</h2>
                <button class="btn-action" onclick="openMedicalHistoryModal()">
                    <i class='bx bx-plus-circle'></i>
                    Add/Update
                </button>
            </div>
            <div class="card-body">
                <div class="medical-history-summary">
                    @if($medicalHistory)
                        <div class="history-section">
                            <div class="history-label">Known Conditions</div>
                            <div class="history-value {{ empty($medicalHistory->known_conditions) ? 'empty' : '' }}">
                                {{ $medicalHistory->known_conditions ?: 'Not specified' }}
                            </div>
                        </div>

                        <div class="history-section">
                            <div class="history-label">Allergies</div>
                            <div class="history-value {{ empty($medicalHistory->allergies) ? 'empty' : '' }}">
                                {{ $medicalHistory->allergies ?: 'None recorded' }}
                            </div>
                        </div>

                        <div class="history-section">
                            <div class="history-label">Current Medications</div>
                            <div class="history-value {{ empty($medicalHistory->current_medications) ? 'empty' : '' }}">
                                {{ $medicalHistory->current_medications ?: 'None recorded' }}
                            </div>
                        </div>

                        <div class="history-section">
                            <div class="history-label">Previous Hospitalization</div>
                            <div class="history-value {{ empty($medicalHistory->previous_hospitalization) ? 'empty' : '' }}">
                                {{ $medicalHistory->previous_hospitalization ?: 'None recorded' }}
                            </div>
                        </div>

                        <div class="history-section">
                            <div class="history-label">Family History</div>
                            <div class="history-value {{ empty($medicalHistory->family_history) ? 'empty' : '' }}">
                                {{ $medicalHistory->family_history ?: 'None recorded' }}
                            </div>
                        </div>

                        <div class="history-section">
                            <div class="history-label">Immunization Status</div>
                            <div class="history-value">
                                <span style="padding: 4px 12px; border-radius: 6px; background: {{ $medicalHistory->immunization_status === 'Complete' ? '#d4edda' : '#fff3cd' }}; color: {{ $medicalHistory->immunization_status === 'Complete' ? '#155724' : '#856404' }};">
                                    {{ $medicalHistory->immunization_status ?? 'Incomplete' }}
                                </span>
                            </div>
                        </div>

                        @if($medicalHistory->remarks)
                        <div class="history-section">
                            <div class="history-label">Remarks</div>
                            <div class="history-value">{{ $medicalHistory->remarks }}</div>
                        </div>
                        @endif

                        <div class="history-section" style="border-bottom: none; padding-top: 15px; margin-top: 15px; border-top: 1px solid #eee;">
                            <div class="history-label" style="font-size: 0.85rem; color: #999;">
                                Last Updated: {{ $medicalHistory->updated_at->format('M d, Y') }}
                            </div>
                        </div>
                    @else
                        <div class="no-data">
                            <p>No medical history recorded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Medical History Form Modal -->
<div id="medicalHistoryModal" class="floating-modal">
    <div class="floating-modal-content">
        <div class="floating-modal-header">
            <h3>Medical History</h3>
            <button class="floating-modal-close" onclick="closeMedicalHistoryModal()">&times;</button>
        </div>
        <form action="{{ route('patient.storeMedicalHistory') }}" method="POST">
            @csrf
            <div class="floating-modal-body">
                <div class="form-group">
                    <label for="known_conditions">Known Conditions</label>
                    <input type="text" id="known_conditions" name="known_conditions" placeholder="Known conditions" value="{{ old('known_conditions', $medicalHistory?->known_conditions ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="allergies">Allergies</label>
                    <input type="text" id="allergies" name="allergies" placeholder="Allergies" value="{{ old('allergies', $medicalHistory?->allergies ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="current_medications">Current Medications</label>
                    <input type="text" id="current_medications" name="current_medications" placeholder="Current medications" value="{{ old('current_medications', $medicalHistory?->current_medications ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="previous_hospitalization">Previous Hospitalization</label>
                    <input type="text" id="previous_hospitalization" name="previous_hospitalization" placeholder="Previous hospitalization" value="{{ old('previous_hospitalization', $medicalHistory?->previous_hospitalization ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="family_history">Family History</label>
                    <input type="text" id="family_history" name="family_history" placeholder="Family history" value="{{ old('family_history', $medicalHistory?->family_history ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="immunization_status">Immunization Status</label>
                    <select id="immunization_status" name="immunization_status">
                        <option value="Incomplete" {{ old('immunization_status', $medicalHistory?->immunization_status ?? 'Incomplete') === 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                        <option value="Complete" {{ old('immunization_status', $medicalHistory?->immunization_status ?? 'Incomplete') === 'Complete' ? 'selected' : '' }}>Complete</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" id="remarks" name="remarks" placeholder="Remarks" value="{{ old('remarks', $medicalHistory?->remarks ?? '') }}">
                </div>
            </div>
            <div class="floating-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeMedicalHistoryModal()">Cancel</button>
                <button type="submit" class="btn-save">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Floating Appointment Details Modal -->
<div id="appointmentDetailsModal" class="floating-modal">
    <div class="floating-modal-content">
        <div class="floating-modal-header">
            <h3>Appointment Details</h3>
            <button class="floating-modal-close" onclick="closeAppointmentDetailsModal()">&times;</button>
        </div>
        <div class="floating-modal-body">
            <div class="form-group">
                <label>Date:</label>
                <input type="text" id="appointment-date" readonly>
            </div>
            <div class="form-group">
                <label>Time:</label>
                <input type="text" id="appointment-time" readonly>
            </div>
            <div class="form-group">
                <label>Type:</label>
                <input type="text" id="appointment-type" readonly>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <input type="text" id="appointment-status" readonly>
            </div>
        </div>
        <div class="floating-modal-footer center-footer">
            <button type="button" class="btn-save" onclick="closeAppointmentDetailsModal()">OK</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openMedicalHistoryModal() {
    document.getElementById('medicalHistoryModal').classList.add('active');
}

function closeMedicalHistoryModal() {
    document.getElementById('medicalHistoryModal').classList.remove('active');
}

function bookAppointment() {
    window.location.href = "{{ route('patient.appointments') }}";
}

function viewAppointmentDetails(appointmentId) {
    // Fetch appointment details via AJAX
    fetch(`/patient/appointments/${appointmentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('appointment-date').value = data.appointment.date;
                document.getElementById('appointment-time').value = data.appointment.time;
                document.getElementById('appointment-type').value = data.appointment.type;
                document.getElementById('appointment-status').value = data.appointment.status;
                document.getElementById('appointmentDetailsModal').classList.add('active');
            } else {
                alert('Failed to load appointment details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading appointment details.');
        });
}

function closeAppointmentDetailsModal() {
    document.getElementById('appointmentDetailsModal').classList.remove('active');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const medicalModal = document.getElementById('medicalHistoryModal');
    const appointmentModal = document.getElementById('appointmentDetailsModal');
    if (event.target === medicalModal) {
        closeMedicalHistoryModal();
    }
    if (event.target === appointmentModal) {
        closeAppointmentDetailsModal();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeMedicalHistoryModal();
        closeAppointmentDetailsModal();
    }
});
</script>
@endpush

