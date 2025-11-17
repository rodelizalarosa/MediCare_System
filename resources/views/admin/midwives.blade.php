@extends('layouts.app')

@php
    $pageTitle = 'Midwives Management';
@endphp

@section('title', 'Midwives Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .midwives-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .midwives-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .midwives-title {
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
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1B4D89;
        margin: 0;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
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

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
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

    .midwives-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .midwives-table th,
    .midwives-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .midwives-table th {
        background: #1B4D89;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .midwives-table tr:hover {
        background: #f8f9fa;
    }

    .midwife-link {
        color: #1B4D89;
        text-decoration: none;
        font-weight: 500;
    }

    .midwife-link:hover {
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

    .no-midwives {
        text-align: center;
        padding: 50px;
        color: #999;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .midwives-container {
            padding: 10px;
        }

        .midwives-table th,
        .midwives-table td {
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
<div class="midwives-container">
    <div class="midwives-header">
        <h1 class="midwives-title">All Midwives</h1>
        <button type="button" class="btn btn-primary" onclick="openModal()">Add Midwife</button>
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

    @if(isset($midwives) && $midwives->count() > 0)
        <div style="overflow-x: auto;">
            <table class="midwives-table">
                <thead>
                    <tr>
                        <th>Midwife ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>License Number</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($midwives as $midwife)
                        <tr>
                            <td>{{ $midwife->midwife_id }}</td>
                            <td>{{ $midwife->first_name }} {{ $midwife->middle_name }} {{ $midwife->last_name }}</td>
                            <td>{{ $midwife->user->email }}</td>
                            <td>{{ $midwife->license_number }}</td>
                            <td>{{ $midwife->contact_number }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-action btn-view">View</button>
                                    <button type="button" class="btn-action btn-edit">Edit</button>
                                    <button type="button" class="btn-action btn-delete">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-midwives">
            <p>No midwives found.</p>
        </div>
    @endif

    <!-- Modal for Adding Midwife -->
    <div id="addMidwifeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add New Midwife</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="addMidwifeForm" method="POST" action="{{ route('admin.midwives.store') }}">
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
                    <label for="license_number">License Number</label>
                    <input type="text" id="license_number" name="license_number" required>
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
</div>

<script>
    function openModal() {
        document.getElementById('addMidwifeModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('addMidwifeModal').style.display = 'none';
        document.getElementById('addMidwifeForm').reset();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        var modal = document.getElementById('addMidwifeModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endsection
