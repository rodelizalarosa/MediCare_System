<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MediCare</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ asset('js/nav.js') }}"></script>
</head>

<body class="auth-body">

     @include('layouts.nav')

<div class="auth-wrapper">

    <!-- LEFT PANEL -->
    <div class="auth-left" style="background:#00B4D8;">
        <div class="auth-left-content">
            <img src="{{ asset('images/logo-medicare.png') }}" class="auth-logo">

            <h1>Welcome Back to<br>MediCare</h1>
            <p>Your healthcare, made more accessible.</p>

        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">

        <h2>Login</h2>
        <p class="subtitle">Enter your email and password to continue.</p>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <input type="password" name="password" required>
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="auth-btn">Login</button>
        </form>

        <p class="auth-switch">
            Don't have an account?
            <a href="{{ route('register') }}">Create one</a>
        </p>

    </div>
</div>

    @include('layouts.footer')

</body>
</html>
