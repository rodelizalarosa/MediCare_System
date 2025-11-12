<!DOCTYPE html>
<html>
<head>
    <title>Verify Email PIN | MediCare</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
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
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Verification PIN</label>
                    <input type="text" name="pin" maxlength="6" required>
                </div>

                <button type="submit" class="btn-auth">Verify Email</button>
            </form>

        </div>
    </section>

    @include('layouts.footer')

</body>
</html>
