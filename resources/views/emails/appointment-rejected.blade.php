<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Rejected</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
            border-left: 4px solid #dc3545;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #1B4D89;
        }
        .rejection-reason {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .rejection-reason h3 {
            color: #c82333;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
        .next-steps {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Appointment Request Update</h1>
        <p>Your appointment request has been reviewed</p>
    </div>

    <div class="content">
        <p>Dear {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }},</p>

        <p>We regret to inform you that your appointment request has been <strong>rejected</strong>. Here are the details:</p>

        <div class="appointment-details">
            <div class="detail-row">
                <span class="detail-label">Appointment ID:</span> {{ $appointment->appointment_id }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Type:</span> {{ $appointment->appointment_type }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Requested Date:</span> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
            </div>
            <div class="detail-row">
                <span class="detail-label">Requested Time:</span> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
            </div>
            @if($appointment->remarks)
            <div class="detail-row">
                <span class="detail-label">Remarks:</span> {{ $appointment->remarks }}
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="status-rejected">REJECTED</span>
            </div>
        </div>

        <div class="rejection-reason">
            <h3>Reason for Rejection:</h3>
            <p>{{ $rejection_reason }}</p>
        </div>

        <div class="next-steps">
            <h3>What happens next?</h3>
            <p>You can:</p>
            <ul>
                <li>Submit a new appointment request with different dates/times</li>
                <li>Contact our clinic directly to discuss alternative arrangements</li>
                <li>Call us to speak with our scheduling team</li>
            </ul>
        </div>

        <p>We apologize for any inconvenience this may cause. Our team is here to help you schedule an appointment that works better for your needs.</p>

        <p>If you have any questions or would like to discuss this further, please don't hesitate to contact our clinic.</p>

        <p>Best regards,<br>
        The BHARMS Clinic Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} BHARMS Clinic. All rights reserved.</p>
    </div>
</body>
</html>
