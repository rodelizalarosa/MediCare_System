<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MediCare Reports - {{ date('F j, Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #1B4D89;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo-text {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1B4D89;
            margin: 0;
        }

        .report-title {
            font-size: 1.8rem;
            color: #666;
            margin: 5px 0;
        }

        .generated-at {
            font-size: 0.9rem;
            color: #888;
            margin-top: 10px;
        }

        .summary-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1B4D89;
            border-bottom: 2px solid #1B4D89;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stats-row {
            display: table-row;
        }

        .stats-cell {
            display: table-cell;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }

        .stats-header {
            background-color: #1B4D89;
            color: white;
            font-weight: bold;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1B4D89;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            margin-top: 2px;
        }

        .category-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .category-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1B4D89;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            padding: 8px;
            border-left: 4px solid #1B4D89;
        }

        .category-stats {
            display: table;
            width: 100%;
        }

        .category-row {
            display: table-row;
        }

        .category-cell {
            display: table-cell;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .category-label {
            font-weight: 500;
            color: #555;
        }

        .category-value {
            text-align: right;
            font-weight: bold;
            color: #1B4D89;
            font-size: 1.2rem;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 0.8rem;
            color: #888;
        }

        @page {
            margin: 1in;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-section">
            <h1 class="logo-text">MediCare</h1>
        </div>
        <h2 class="report-title">System Reports Summary</h2>
        <p class="generated-at">Generated on: {{ $generatedAt }}</p>
    </div>

    <div class="summary-section">
        <h3 class="section-title">📊 Overall Summary</h3>

        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-header">Category</div>
                <div class="stats-cell stats-header">Total</div>
                <div class="stats-cell stats-header">Active/In Progress</div>
                <div class="stats-cell stats-header">Completed</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Patients</div>
                <div class="stats-cell">
                    <span class="stat-number">{{ $totalPatients }}</span>
                </div>
                <div class="stats-cell">
                    <span class="stat-number">{{ $activePatients }}</span>
                    <div class="stat-label">Active</div>
                </div>
                <div class="stats-cell">
                    <span class="stat-number">{{ $inactivePatients }}</span>
                    <div class="stat-label">Inactive</div>
                </div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Appointments</div>
                <div class="stats-cell">
                    <span class="stat-number">{{ $totalAppointments }}</span>
                </div>
                <div class="stats-cell">
                    <span class="stat-number">{{ $pendingAppointments + $approvedAppointments }}</span>
                    <div class="stat-label">Pending/Approved</div>
                </div>
                <div class="stats-cell">
                    <span class="stat-number">{{ $completedAppointments }}</span>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
        </div>
    </div>

    <div class="category-section">
        <h4 class="category-title">👥 Patient Statistics</h4>
        <div class="category-stats">
            <div class="category-row">
                <div class="category-cell category-label">Total Patients Registered</div>
                <div class="category-cell category-value">{{ $totalPatients }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Active Patient Records</div>
                <div class="category-cell category-value">{{ $activePatients }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Inactive Patient Records</div>
                <div class="category-cell category-value">{{ $inactivePatients }}</div>
            </div>
        </div>
    </div>

    <div class="category-section">
        <h4 class="category-title">📅 Appointment Statistics</h4>
        <div class="category-stats">
            <div class="category-row">
                <div class="category-cell category-label">Total Appointments</div>
                <div class="category-cell category-value">{{ $totalAppointments }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Pending Appointments</div>
                <div class="category-cell category-value">{{ $pendingAppointments }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Approved Appointments</div>
                <div class="category-cell category-value">{{ $approvedAppointments }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Completed Appointments</div>
                <div class="category-cell category-value">{{ $completedAppointments }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Cancelled Appointments</div>
                <div class="category-cell category-value">{{ $cancelledAppointments }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Rejected Appointments</div>
                <div class="category-cell category-value">{{ $rejectedAppointments }}</div>
            </div>
        </div>
    </div>

    <div class="category-section">
        <h4 class="category-title">👨‍⚕️ Staff Statistics</h4>
        <div class="category-stats">
            <div class="category-row">
                <div class="category-cell category-label">Total Staff Members</div>
                <div class="category-cell category-value">{{ $totalStaff }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Registered Doctors</div>
                <div class="category-cell category-value">{{ $totalDoctors }}</div>
            </div>
            <div class="category-row">
                <div class="category-cell category-label">Registered Midwives</div>
                <div class="category-cell category-value">{{ $totalMidwives }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This report was generated automatically by the MediCare System</p>
        <p>© {{ date('Y') }} MediCare. All rights reserved.</p>
    </div>
</body>
</html>
