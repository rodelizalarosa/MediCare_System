@extends('layouts.app')

@php
    $pageTitle = 'Admin Dashboard';
@endphp

@section('title', 'Admin Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .dashboard-container {
        padding: 0px 20px 20px 40px; /* push content slightly to the right */
    }

    .dashboard-grid-top {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    @media (max-width: 1200px) {
        .dashboard-grid-top {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid-top {
            grid-template-columns: 1fr;
        }
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
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
        font-size: 1.1rem;
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

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1B4D89;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .recent-activity {
        max-height: 300px;
        overflow-y: auto;
    }

    .activity-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 12px;
        border-left: 4px solid #1B4D89;
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 5px;
    }

    .activity-description {
        font-weight: 500;
        color: #333;
    }

    .no-data {
        text-align: center;
        padding: 30px;
        color: #999;
        font-style: italic;
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

    .status-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        display: inline-block;
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

    <div class="dashboard-grid-top">
        <!-- Total Patients Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Total Patients</h2>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $totalPatients ?? 0 }}</div>
                <div class="stat-label">Registered patients</div>
            </div>
        </div>

        <!-- Total Appointments Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Total Appointments</h2>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $totalAppointments ?? 0 }}</div>
                <div class="stat-label">Scheduled appointments</div>
            </div>
        </div>

        <!-- Pending Appointments Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Pending Appointments</h2>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $pendingAppointments ?? 0 }}</div>
                <div class="stat-label">Awaiting approval</div>
            </div>
        </div>

        <!-- Today's Appointments Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Today's Appointments</h2>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $todayAppointments ?? 0 }}</div>
                <div class="stat-label">Scheduled for today</div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Recent Appointments Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Recent Appointments</h2>
                <button class="btn-action" onclick="window.location.href='{{ route('admin.appointments') }}'">
                    <i class='bx bx-list-ul'></i>
                    View All
                </button>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @if(isset($recentAppointments) && count($recentAppointments) > 0)
                        @foreach($recentAppointments as $appointment)
                            <div class="activity-item">
                                <div class="activity-time">{{ $appointment->appointment_date }} at {{ $appointment->appointment_time }}</div>
                                <div class="activity-description">
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }} - {{ $appointment->appointment_type }}
                                    <span class="status-badge status-{{ strtolower($appointment->appointment_status) }}">
                                        {{ $appointment->appointment_status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-data">
                            <p>No recent appointments.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Patient Registrations Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Recent Registrations</h2>
                <button class="btn-action" onclick="window.location.href='{{ route('admin.patients') }}'">
                    <i class='bx bx-list-ul'></i>
                    View All
                </button>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @if(isset($recentPatients) && count($recentPatients) > 0)
                        @foreach($recentPatients as $patient)
                            <div class="activity-item">
                                <div class="activity-time">{{ $patient->created_at->format('M d, Y') }}</div>
                                <div class="activity-description">
                                    {{ $patient->first_name }} {{ $patient->last_name }} - {{ $patient->email }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-data">
                            <p>No recent registrations.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Add any dashboard-specific JavaScript here
</script>
@endpush
