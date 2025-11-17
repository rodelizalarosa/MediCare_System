@extends('layouts.app')

@php
    $pageTitle = 'Staff Management';
@endphp

@section('title', 'Staff Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .staff-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .staff-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .staff-title {
        font-family: 'Noto Serif', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #1B4D89;
        margin: 0;
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

    .staff-details-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .staff-details-table th,
    .staff-details-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .staff-details-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        width: 30%;
    }

    .staff-details-table input,
    .staff-details-table select,
    .staff-details-table textarea {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .staff-details-table textarea {
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

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .btn-primary {
        background: #1B4D89;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #153d6a;
    }

    .staff-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .staff-table th,
    .staff-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .staff-table th {
        background: #1B4D89;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .staff-table tr:hover {
        background: #f8f9fa;
    }

    .staff-link {
        color: #1B4D89;
        text-decoration: none;
        font-weight: 500;
    }

    .staff-link:hover {
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

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .no-staff {
        text-align: center;
        padding: 50px;
        color: #999;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .staff-container {
            padding: 10px;
        }

        .staff-table th,
        .staff-table td {
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
<div class="staff-container">
    <div class="staff-header">
        <h1 class="staff-title">All Staff</h1>
        <button type="button" class="btn btn-primary" onclick="openModal()">Add Staff</button>
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

    @if(isset($staff) && $staff->count() > 0)
        <div style="overflow-x: auto;">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $member)
                        <tr>
                            <td>{{ $member->staff_id }}</td>
                            <td>{{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}</td>
                            <td>{{ $member->user->email }}</td>
                            <td>{{ $member->position }}</td>
                            <td>{{ $member->contact_number }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-action btn-view" onclick="viewStaffDetails({{ $member->staff_id }})">View Details</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-staff">
            <p>No staff members found.</p>
        </div>
    @endif

    <!-- Modal for Adding Staff -->
    <div id="addStaffModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add New Staff</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="addStaffForm" method="POST" action="{{ route('admin.staff.store') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <small style="color: #666;">Note: User should change this password after first login.</small>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="sex">Sex</label>
                    <select id="sex" name="sex">
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="birth_date">Birth Date</label>
                    <input type="date" id="birth_date" name="birth_date">
                </div>
                <div class="form-group">
                    <label for="position">Position</label>
                    <select id="position" name="position" required>
                        <option value="">Select Position</option>
                        <option value="Health Worker">Health Worker</option>
                        <option value="Barangay Nurse">Barangay Nurse</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Details Modal -->
    <div id="staffModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Staff Details</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div id="staffDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-edit-modal" id="editBtn" onclick="enableEditMode()">Edit</button>
                <button type="button" class="btn-modal btn-ok" id="okBtn" onclick="closeModal()">OK</button>
                <button type="button" class="btn-modal btn-save" id="saveBtn" onclick="saveStaff()" style="display: none;">Save</button>
                <button type="button" class="btn-modal btn-cancel" id="cancelBtn" onclick="cancelEdit()" style="display: none;">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentStaffId = null;
let originalStaffData = {};

function viewStaffDetails(staffId) {
    currentStaffId = staffId;

    // Fetch staff data via AJAX
    fetch('/admin/staff/' + staffId + '?action=view', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        displayStaffDetails(data.staff, data.user);
        document.getElementById('staffModal').style.display = 'block';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading staff details');
    });
}

function displayStaffDetails(staff, user) {
    const content = document.getElementById('staffDetailsContent');

    content.innerHTML = `
        <h3 class="section-title">Personal Information</h3>
        <table class="staff-details-table">
            <tr>
                <th>Staff ID:</th>
                <td><span id="display-staff-id">${staff.staff_id}</span></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>
                    <span id="display-email">${user.email}</span>
                    <input type="email" id="edit-email" value="${user.email}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>First Name:</th>
                <td>
                    <span id="display-first-name">${staff.first_name}</span>
                    <input type="text" id="edit-first-name" value="${staff.first_name}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Middle Name:</th>
                <td>
                    <span id="display-middle-name">${staff.middle_name || ''}</span>
                    <input type="text" id="edit-middle-name" value="${staff.middle_name || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Last Name:</th>
                <td>
                    <span id="display-last-name">${staff.last_name}</span>
                    <input type="text" id="edit-last-name" value="${staff.last_name}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Sex:</th>
                <td>
                    <span id="display-sex">${staff.sex || 'N/A'}</span>
                    <select id="edit-sex" style="display: none;">
                        <option value="Male" ${staff.sex === 'Male' ? 'selected' : ''}>Male</option>
                        <option value="Female" ${staff.sex === 'Female' ? 'selected' : ''}>Female</option>
                        <option value="Other" ${staff.sex === 'Other' ? 'selected' : ''}>Other</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Birth Date:</th>
                <td>
                    <span id="display-birth-date">${staff.birth_date ? new Date(staff.birth_date).toLocaleDateString() : 'N/A'}</span>
                    <input type="date" id="edit-birth-date" value="${staff.birth_date || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Position:</th>
                <td>
                    <span id="display-position">${staff.position}</span>
                    <select id="edit-position" style="display: none;">
                        <option value="Health Worker" ${staff.position === 'Health Worker' ? 'selected' : ''}>Health Worker</option>
                        <option value="Barangay Nurse" ${staff.position === 'Barangay Nurse' ? 'selected' : ''}>Barangay Nurse</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Contact Number:</th>
                <td>
                    <span id="display-contact-number">${staff.contact_number || 'N/A'}</span>
                    <input type="text" id="edit-contact-number" value="${staff.contact_number || ''}" style="display: none;">
                </td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>
                    <span id="display-address">${staff.address || 'N/A'}</span>
                    <textarea id="edit-address" style="display: none;">${staff.address || ''}</textarea>
                </td>
            </tr>
        </table>
    `;

    // Store original data for cancel functionality
    originalStaffData = {
        staff: { ...staff },
        user: { ...user }
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
    displayStaffDetails(originalStaffData.staff, originalStaffData.user);

    // Toggle buttons back
    document.getElementById('editBtn').style.display = 'inline-block';
    document.getElementById('okBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
}

function saveStaff() {
    const formData = new FormData();

    // Collect staff data
    formData.append('first_name', document.getElementById('edit-first-name').value);
    formData.append('middle_name', document.getElementById('edit-middle-name').value);
    formData.append('last_name', document.getElementById('edit-last-name').value);
    formData.append('sex', document.getElementById('edit-sex').value);
    formData.append('birth_date', document.getElementById('edit-birth-date').value);
    formData.append('position', document.getElementById('edit-position').value);
    formData.append('contact_number', document.getElementById('edit-contact-number').value);
    formData.append('address', document.getElementById('edit-address').value);
    formData.append('email', document.getElementById('edit-email').value);

    // Send update request
    fetch('/admin/staff/' + currentStaffId, {
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
            alert('Staff information updated successfully!');
            closeModal();
            location.reload(); // Refresh to show updated data
        } else {
            alert('Error updating staff information: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating staff information');
    });
}

function openModal() {
    document.getElementById('addStaffModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('addStaffModal').style.display = 'none';
    document.getElementById('staffModal').style.display = 'none';
    document.getElementById('addStaffForm').reset();
    currentStaffId = null;
    originalStaffData = {};
}

// Close modal when clicking outside
window.onclick = function(event) {
    const addModal = document.getElementById('addStaffModal');
    const viewModal = document.getElementById('staffModal');
    if (event.target == addModal || event.target == viewModal) {
        closeModal();
    }
}
</script>
@endpush
