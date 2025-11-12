<!-- NAVIGATION -->
<header class="navbar">
    <nav class="nav-links">
        <a href="{{ route('homepage') }}" class="nav-logo">
            <img src="{{ asset('images/logo-medicare.png') }}" alt="MediCare Logo">
            <span>MEDICARE</span>
        </a>
        <div class="nav-menu">
            <a href="#hero">Home</a>
            <a href="#services">Services</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        </div>
    </nav>
</header>
