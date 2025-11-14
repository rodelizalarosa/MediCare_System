<div class="sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo-container">
        <div class="logo-circle">
            <img src="{{ asset('images/logo-medicare.png') }}" alt="MediCare Logo">
        </div>
        <span class="logo-text">MediCare</span>
    </div>

    <!-- MENU -->
    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('dashboard.patient') }}" class="sidebar-link" data-requires-profile="true">
                <i class='bx bx-home-alt'></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('patient.records') }}" class="sidebar-link" data-requires-profile="true">
                <i class='bx bx-file'></i>
                <span>My Records</span>
            </a>
        </li>

        <li>
            <a href="{{ route('patient.appointments') }}" class="sidebar-link" data-requires-profile="true">
                <i class='bx bx-calendar-plus'></i>
                <span>Book Appointment</span>
            </a>
        </li>

        <li>
            <a href="{{ route('patient.profile') }}" class="sidebar-link" data-requires-profile="true">
                <i class='bx bx-user'></i>
                <span>My Profile</span>
            </a>
        </li>

    </ul>

</div>
