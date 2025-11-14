<!-- NAVIGATION -->
<header class="navbar">
    <nav class="nav-links">
        <a href="{{ route('homepage') }}" class="nav-logo">
            <img src="{{ asset('images/logo-medicare.png') }}" alt="MediCare Logo">
            <span>MEDICARE</span>
        </a>
        <div class="nav-menu" id="navMenu">
            <a href="#hero">Home</a>
            <a href="#services">Services</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <i class='bx bx-menu'></i>
        </button>
    </nav>
</header>
