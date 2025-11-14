<!DOCTYPE html>
<html>
<head>
    <title>Verify Email PIN | MediCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/verify-pin.css') }}?v={{ time() }}">
</head>

<body class="auth-page">

@include('layouts.nav')

<section class="auth-section">
    <div class="auth-container">

        <h2>Email Verification</h2>
        <p>Enter the 6-digit verification PIN sent to your email.</p>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('verify.pin') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input id="emailInput" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Verification PIN</label>
                <input type="text" name="pin" maxlength="6" required>
            </div>

            <button type="submit" class="btn-auth">Verify Email</button>
        </form>

        <form id="resendForm" action="{{ route('resend.pin') }}" method="POST" class="resend-form">
            @csrf
            <input type="hidden" id="resendEmail" name="email">
            <button type="submit" class="btn-link">Didn't receive the PIN? Resend</button>
        </form>

    </div>
</section>

@include('layouts.footer')

<script>
    // Always copy the email from main input to resend input
    document.getElementById('resendForm').addEventListener('submit', function () {
        document.getElementById('resendEmail').value = document.getElementById('emailInput').value;
    });
</script>

</body>
</html>
