<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #1B4D89 0%, #2E6BC6 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px 20px;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .appointment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #1B4D89;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Appointment Approved</h1>
        <p>Your appointment has been confirmed!</p>
    </div>

    <div class="content">
        <p>Dear {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }},</p>

        <p>Great news! Your appointment request has been <strong>approved</strong>. Here are the details:</p>

        <div class="appointment-details">
            <div class="detail-row">
                <span class="detail-label">Appointment ID:</span> {{ $appointment->appointment_id }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Type:</span> {{ $appointment->appointment_type }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Date:</span> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Time:</span> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
            </div>
            @if($appointment->remarks)
            <div class="detail-row">
                <span class="detail-label">Remarks:</span> {{ $appointment->remarks }}
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="status-approved">APPROVED</span>
            </div>
        </div>

        <p><strong>Important Reminders:</strong></p>
        <ul>
            <li>Please arrive 15 minutes before your scheduled appointment time.</li>
            <li>Bring any relevant medical records or test results.</li>
            <li>If you need to reschedule or cancel, please contact us at least 24 hours in advance.</li>
        </ul>

        <p>If you have any questions or need to make changes to your appointment, please don't hesitate to contact our clinic.</p>

        <p>We look forward to seeing you!</p>

        <p>Best regards,<br>
        The BHARMS Clinic Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} BHARMS Clinic. All rights reserved.</p>
    </div>
</body>
</html>
