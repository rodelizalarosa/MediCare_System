@extends('layouts.app')

@php
    $pageTitle = 'Patient Records';
@endphp

@section('title', 'Admin - Patients')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .patients-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .patients-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .patients-title {
        font-family: 'Noto Serif', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #1B4D89;
        margin: 0;
    }

    .patients-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .patients-table th,
    .patients-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .patients-table th {
        background: #1B4D89;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .patients-table tr:hover {
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

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
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

    .btn-view {
        background: #17a2b8;
        color: white;
    }

    .btn-view:hover {
        background: #138496;
    }

    .btn-edit {
        background: #ffc107;
        color: #212529;
    }

    .btn-edit:hover {
        background: #e0a800;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow-y: auto;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 0;
        border: 1px solid #888;
        width: 90%;
        max-width: 800px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        background: #1B4D89;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
    }

    .close:hover,
    .close:focus {
        color: white;
    }

    .modal-body {
        padding: 20px;
        max-height: 400px;
        overflow-y: auto;
        padding-right: 5px; /* Space for scrollbar */
    }

    /* Custom scrollbar for modal body */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f0f0f5;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background-color: #1B4D89;
        border-radius: 10px;
    }

    .patient-details-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .patient-details-table th,
    .patient-details-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .patient-details-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        width: 30%;
    }

    .patient-details-table input,
    .patient-details-table select,
    .patient-details-table textarea {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .patient-details-table textarea {
        resize: vertical;
        min-height: 60px;
    }

    .modal-footer {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 0 0 12px 12px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-modal {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-ok {
        background: #28a745;
        color: white;
    }

    .btn-ok:hover {
        background: #218838;
    }

    .btn-edit-modal {
        background: #ffc107;
        color: #212529;
    }

    .btn-edit-modal:hover {
        background: #e0a800;
    }

    .btn-save {
        background: #007bff;
        color: white;
    }

    .btn-save:hover {
        background: #0056b3;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
    }

    .btn-cancel:hover {
        background: #545b62;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1B4D89;
        margin: 20px 0 10px 0;
        padding-bottom: 5px;
        border-bottom: 2px solid #1B4D89;
    }

    .no-patients {
        text-align: center;
        padding: 50px;
        color: #999;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .patients-container {
            padding: 10px;
        }

        .patients-table th,
        .patients-table td {
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
<div class="patients-container">
    <div class="patients-header">
        <h1 class="patients-title">All Patients</h1>
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

    @if(isset($patients) && $patients->count() > 0)
        <div style="overflow-x: auto;">
            <table class="patients-table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Birth Date</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>
                                <a href="{{ route('admin.patients') }}?patient={{ $patient->id }}" class="patient-link">
                                    {{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}
                                </a>
                            </td>
                            <td>{{ $patient->sex }}</td>
                            <td>{{ \Carbon\Carbon::parse($patient->birth_date)->format('F j, Y') }}</td>
                            <td>{{ $patient->contact_number }}</td>
                            <td>{{ $patient->address ?: 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($patient->record_status ?? 'active') }}">
                                    {{ $patient->record_status ?? 'Active' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-action btn-view" onclick="viewPatientDetails({{ $patient->id }})">View Details</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-patients">
            <p>No patients found.</p>
        </div>
    @endif

    <!-- Patient Details Modal -->
    <div id="patientModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Patient Details</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div id="patientDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-edit-modal" id="editBtn" onclick="enableEditMode()">Edit</button>
                <button type="button" class="btn-modal btn-ok" id="okBtn" onclick="closeModal()">OK</button>
                <button type="button" class="btn-modal btn-save" id="saveBtn" onclick="savePatient()" style="display: none;">Save</button>
                <button type="button" class="btn-modal btn-cancel" id="cancelBtn" onclick="cancelEdit()" style="display: none;">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPatientId = null;
let originalData = {};

function viewPatientDetails(patientId) {
    currentPatientId = patientId;

    // Fetch patient data via AJAX
    fetch('{{ route("admin.patients") }}?patient=' + patientId + '&action=view', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        displayPatientDetails(data.patient, data.medicalHistory);
        document.getElementById('patientModal').style.display = 'block';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading patient details');
    });
}

function editPatient(patientId) {
    viewPatientDetails(patientId);
    setTimeout(() => {
        enableEditMode();
    }, 100);
}

function displayPatientDetails(patient, medicalHistory) {
    const content = document.getElementById('patientDetailsContent');

    content.innerHTML = `
        <h3 class="section-title">Personal Information</h3>
        <table class="patient-details-table">
            <tr>
                <th>Patient ID:</th>
                <td><span id="display-patient-id">${patient.id}</span></td>
            </tr>
            <tr>
                <th>First Name:</th>
                <td>
                    <span id="display-first-name">${patient.first_name}</span>
                    <input type="text" id="edit-first-name" value="${patient.first_name}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Middle Name:</th>
                <td>
                    <span id="display-middle-name">${patient.middle_name || ''}</span>
                    <input type="text" id="edit-middle-name" value="${patient.middle_name || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Last Name:</th>
                <td>
                    <span id="display-last-name">${patient.last_name}</span>
                    <input type="text" id="edit-last-name" value="${patient.last_name}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Sex:</th>
                <td>
                    <span id="display-sex">${patient.sex}</span>
                    <select id="edit-sex" style="display: none;">
                        <option value="Male" ${patient.sex === 'Male' ? 'selected' : ''}>Male</option>
                        <option value="Female" ${patient.sex === 'Female' ? 'selected' : ''}>Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Birth Date:</th>
                <td>
                    <span id="display-birth-date">${new Date(patient.birth_date).toLocaleDateString()}</span>
                    <input type="date" id="edit-birth-date" value="${patient.birth_date}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Civil Status:</th>
                <td>
                    <span id="display-civil-status">${patient.civil_status || 'N/A'}</span>
                    <select id="edit-civil-status" style="display: none;">
                        <option value="Single" ${patient.civil_status === 'Single' ? 'selected' : ''}>Single</option>
                        <option value="Married" ${patient.civil_status === 'Married' ? 'selected' : ''}>Married</option>
                        <option value="Divorced" ${patient.civil_status === 'Divorced' ? 'selected' : ''}>Divorced</option>
                        <option value="Widowed" ${patient.civil_status === 'Widowed' ? 'selected' : ''}>Widowed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Contact Number:</th>
                <td>
                    <span id="display-contact-number">${patient.contact_number}</span>
                    <input type="text" id="edit-contact-number" value="${patient.contact_number}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>
                    <span id="display-address">${patient.address || 'N/A'}</span>
                    <textarea id="edit-address" style="display: none;">${patient.address || ''}</textarea>
                </td>
            </tr>
            <tr>
                <th>Emergency Contact Name:</th>
                <td>
                    <span id="display-emergency-contact-name">${patient.emergency_contact_name || 'N/A'}</span>
                    <input type="text" id="edit-emergency-contact-name" value="${patient.emergency_contact_name || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Emergency Contact Number:</th>
                <td>
                    <span id="display-emergency-contact-number">${patient.emergency_contact_number || 'N/A'}</span>
                    <input type="text" id="edit-emergency-contact-number" value="${patient.emergency_contact_number || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Relationship to Patient:</th>
                <td>
                    <span id="display-relationship-to-patient">${patient.relationship_to_patient || 'N/A'}</span>
                    <input type="text" id="edit-relationship-to-patient" value="${patient.relationship_to_patient || ''}" style="display: none;">
                </td>
            </tr>
        </table>

        <h3 class="section-title">Medical History</h3>
        <table class="patient-details-table">
            <tr>
                <th>Known Conditions:</th>
                <td>
                    <span id="display-known-conditions">${medicalHistory?.known_conditions || 'None'}</span>
                    <input type="text" id="edit-known-conditions" value="${medicalHistory?.known_conditions || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Allergies:</th>
                <td>
                    <span id="display-allergies">${medicalHistory?.allergies || 'None'}</span>
                    <input type="text" id="edit-allergies" value="${medicalHistory?.allergies || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Current Medications:</th>
                <td>
                    <span id="display-medications">${medicalHistory?.current_medications || 'None'}</span>
                    <input type="text" id="edit-medications" value="${medicalHistory?.current_medications || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Previous Hospitalizations:</th>
                <td>
                    <span id="display-hospitalizations">${medicalHistory?.previous_hospitalizations || 'None'}</span>
                    <input type="text" id="edit-hospitalizations" value="${medicalHistory?.previous_hospitalizations || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Family History:</th>
                <td>
                    <span id="display-family-history">${medicalHistory?.family_history || 'None'}</span>
                    <input type="text" id="edit-family-history" value="${medicalHistory?.family_history || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Immunization Status:</th>
                <td>
                    <span id="display-immunization">${medicalHistory?.immunization_status || 'Not specified'}</span>
                    <input type="text" id="edit-immunization" value="${medicalHistory?.immunization_status || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Remarks:</th>
                <td>
                    <span id="display-remarks">${medicalHistory?.remarks || 'None'}</span>
                    <input type="text" id="edit-remarks" value="${medicalHistory?.remarks || ''}" style="display: none;">
                </td>
            </tr>
        </table>
    `;

    // Store original data for cancel functionality
    originalData = {
        patient: { ...patient },
        medicalHistory: medicalHistory ? { ...medicalHistory } : null
    };
}

function enableEditMode() {
    // Hide display elements and show edit inputs
    const displayElements = document.querySelectorAll('[id^="display-"]');
    const editElements = document.querySelectorAll('[id^="edit-"]');

    displayElements.forEach(el => el.style.display = 'none');
    editElements.forEach(el => el.style.display = 'block');

    // Toggle buttons
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('okBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';
}

function cancelEdit() {
    // Restore original data
    displayPatientDetails(originalData.patient, originalData.medicalHistory);

    // Toggle buttons back
    document.getElementById('editBtn').style.display = 'inline-block';
    document.getElementById('okBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
}

function savePatient() {
    const formData = new FormData();

    // Collect patient data
    formData.append('first_name', document.getElementById('edit-first-name').value);
    formData.append('middle_name', document.getElementById('edit-middle-name').value);
    formData.append('last_name', document.getElementById('edit-last-name').value);
    formData.append('sex', document.getElementById('edit-sex').value);
    formData.append('birth_date', document.getElementById('edit-birth-date').value);
    formData.append('civil_status', document.getElementById('edit-civil-status').value);
    formData.append('contact_number', document.getElementById('edit-contact-number').value);
    formData.append('address', document.getElementById('edit-address').value);
    formData.append('emergency_contact_name', document.getElementById('edit-emergency-contact-name').value);
    formData.append('emergency_contact_number', document.getElementById('edit-emergency-contact-number').value);
    formData.append('relationship_to_patient', document.getElementById('edit-relationship-to-patient').value);

    // Collect medical history data
    formData.append('known_conditions', document.getElementById('edit-known-conditions').value);
    formData.append('allergies', document.getElementById('edit-allergies').value);
    formData.append('current_medications', document.getElementById('edit-medications').value);
    formData.append('previous_hospitalizations', document.getElementById('edit-hospitalizations').value);
    formData.append('family_history', document.getElementById('edit-family-history').value);
    formData.append('immunization_status', document.getElementById('edit-immunization').value);
    formData.append('remarks', document.getElementById('edit-remarks').value);

    // Send update request
    fetch('{{ route("admin.patients") }}/' + currentPatientId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Patient information updated successfully!');
            closeModal();
            location.reload(); // Refresh to show updated data
        } else {
            alert('Error updating patient information: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating patient information');
    });
}

function closeModal() {
    document.getElementById('patientModal').style.display = 'none';
    currentPatientId = null;
    originalData = {};
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('patientModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
@endpush
