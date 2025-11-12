<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MediCare Email Verification</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding: 30px;">

    <div style="max-width: 550px; margin: auto; background: white; padding: 25px 35px; border-radius: 10px; border: 1px solid #e3e3e3;">

        <h2 style="color:#003C77; text-align:center; margin-bottom: 5px;">
            MediCare – Email Verification
        </h2>

        <p style="font-size: 15px; color:#333;">
            Dear <strong>{{ $name }}</strong>,
        </p>

        <p style="font-size: 15px; color:#333; line-height: 1.6;">
            Thank you for registering with <strong>MediCare Barangay Health Clinic</strong>.
            To complete the setup of your account, please use the verification code below:
        </p>

        <div style="background:#003C77; padding: 18px; text-align:center; border-radius: 8px; margin: 25px 0;">
            <span style="font-size: 28px; color: #F4A700; font-weight: bold; letter-spacing: 2px;">
                {{ $pin }}
            </span>
        </div>

        <p style="font-size: 14px; color:#555; line-height: 1.6;">
            This verification PIN is valid for a limited time. Please keep it confidential and do not share it with anyone.
        </p>

        <br>

        <p style="font-size: 15px; color:#333;">
            Sincerely,<br>
            <strong>MediCare Barangay Health Clinic Team</strong>
        </p>

    </div>

</body>
</html>
