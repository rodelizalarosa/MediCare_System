@extends('layouts.app')

@php
    $pageTitle = 'Reports';
@endphp

@section('title', 'Admin - Reports')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .reports-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .reports-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .reports-title {
        font-family: 'Noto Serif', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #1B4D89;
        margin: 0;
    }

    .btn-generate-pdf {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
    }

    .btn-generate-pdf:hover {
        background: #218838;
        text-decoration: none;
        color: white;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border-left: 4px solid #1B4D89;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1B4D89;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .card-title i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .card-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .stat-item {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1B4D89;
        display: block;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #666;
        margin-top: 2px;
    }

    .detailed-section {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1B4D89;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .stat-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #e9ecef;
    }

    .stat-box.large {
        grid-column: span 2;
    }

    .stat-box .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1B4D89;
        display: block;
        margin-bottom: 5px;
    }

    .stat-box .stat-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .reports-container {
            padding: 10px;
        }

        .reports-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .summary-cards {
            grid-template-columns: 1fr;
        }

        .card-stats {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-box.large {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('content')
<div class="reports-container">
    <div class="reports-header">
        <h1 class="reports-title">MediCare Reports</h1>
        <a href="{{ route('admin.reports.generate-pdf') }}" class="btn-generate-pdf" target="_blank">
            <i class="bx bx-download"></i> Generate PDF Report
        </a>
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

    <!-- Patient Summary -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="card-title">
                <i class='bx bx-group'></i>
                Patient Summary
            </div>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $totalPatients }}</span>
                    <span class="stat-label">Total Patients</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $activePatients }}</span>
                    <span class="stat-label">Active</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $inactivePatients }}</span>
                    <span class="stat-label">Inactive</span>
                </div>
            </div>
        </div>

        <!-- Appointment Summary -->
        <div class="summary-card">
            <div class="card-title">
                <i class='bx bx-calendar-plus'></i>
                Appointment Summary
            </div>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $totalAppointments }}</span>
                    <span class="stat-label">Total</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $pendingAppointments }}</span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $approvedAppointments }}</span>
                    <span class="stat-label">Approved</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $completedAppointments }}</span>
                    <span class="stat-label">Completed</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $cancelledAppointments }}</span>
                    <span class="stat-label">Cancelled</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $rejectedAppointments }}</span>
                    <span class="stat-label">Rejected</span>
                </div>
            </div>
        </div>

        <!-- Staff Summary -->
        <div class="summary-card">
            <div class="card-title">
                <i class='bx bx-user-plus'></i>
                Staff Summary
            </div>
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $totalStaff }}</span>
                    <span class="stat-label">Staff</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalDoctors }}</span>
                    <span class="stat-label">Doctors</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $totalMidwives }}</span>
                    <span class="stat-label">Midwives</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="detailed-section">
        <div class="section-title">
            <i class='bx bx-bar-chart-alt-2'></i>
            Detailed Statistics
        </div>
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-number">{{ $totalPatients }}</span>
                <span class="stat-label">Total Patients Registered</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $activePatients }}</span>
                <span class="stat-label">Active Patient Records</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $inactivePatients }}</span>
                <span class="stat-label">Inactive Patient Records</span>
            </div>
            <div class="stat-box large">
                <span class="stat-number">{{ $totalAppointments }}</span>
                <span class="stat-label">Total Appointments Scheduled</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $pendingAppointments }}</span>
                <span class="stat-label">Pending Appointments</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $approvedAppointments }}</span>
                <span class="stat-label">Approved Appointments</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $completedAppointments }}</span>
                <span class="stat-label">Completed Appointments</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $cancelledAppointments }}</span>
                <span class="stat-label">Cancelled Appointments</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $rejectedAppointments }}</span>
                <span class="stat-label">Rejected Appointments</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalStaff }}</span>
                <span class="stat-label">Total Staff Members</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalDoctors }}</span>
                <span class="stat-label">Registered Doctors</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalMidwives }}</span>
                <span class="stat-label">Registered Midwives</span>
            </div>
        </div>
    </div>
</div>
@endsection
