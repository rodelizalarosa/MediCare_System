<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MediCare</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ asset('js/nav.js') }}"></script>
</head>

<body class="auth-body">

    @include('layouts.nav')

<div class="auth-wrapper">

    <!-- LEFT PANEL -->
    <div class="auth-left" style="background:#003C77;">
        <div class="auth-left-content">
            <img src="{{ asset('images/logo-medicare.png') }}" class="auth-logo">

            <h1>Create Your<br>MediCare Account</h1>
            <p>Book your consultations, monitor your records, and access your health data anytime.</p>

        </div>
    </div>

    <!-- RIGHT PANEL (FORM) -->
    <div class="auth-right">

        <h2>Create Account</h2>
        <p class="subtitle">Fill out your details to get started.</p>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-row three-fields">
                <div class="form-group">
                    <label>First Name <span class="required">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name') }}">
                </div>

                <div class="form-group">
                    <label>Last Name <span class="required">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date of Birth <span class="required">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required max="{{ date('Y-m-d') }}">
                    @error('birth_date') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Sex <span class="required">*</span></label>
                    <select name="sex" required>
                        <option value="">Select...</option>
                        <option value="Male" {{ old('sex')=='Male'?'selected':'' }}>Male</option>
                        <option value="Female" {{ old('sex')=='Female'?'selected':'' }}>Female</option>
                        <option value="Other" {{ old('sex')=='Other'?'selected':'' }}>Other</option>
                    </select>
                    @error('sex') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="password" required>
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="auth-btn">Create Account</button>
        </form>

        <p class="auth-switch">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
        </p>

    </div>

</div>

    @include('layouts.footer')
    
</body>
</html>
