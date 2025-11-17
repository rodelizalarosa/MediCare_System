<div class="sidebar admin-sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo-container">
        <div class="logo-circle">
            <img src="{{ asset('images/logo-medicare.png') }}" alt="MediCare Logo">
        </div>
        <span class="logo-text">MediCare</span>
    </div>

    <!-- WELCOME TEXT -->
    <div class="welcome-section">
        <p class="welcome-text">Welcome, Health Worker</p>
        <hr class="separator">
    </div>

    <!-- MENU -->
    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class='bx bx-home-alt'></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.appointments') }}" class="sidebar-link {{ request()->routeIs('admin.appointments') ? 'active' : '' }}">
                <i class='bx bx-calendar-plus'></i>
                <span>Appointments</span>
            </a>
        </li>

        <li class="menu-title">
            <i class='bx bx-users'></i>
            <span>User Management</span>
        </li>

        <li>
            <a href="{{ route('admin.patients') }}" class="sidebar-link {{ request()->routeIs('admin.patients') ? 'active' : '' }}">
                <i class='bx bx-file'></i>
                <span>Patient Records</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.staff') }}" class="sidebar-link {{ request()->routeIs('admin.staff') ? 'active' : '' }}">
                <i class='bx bx-group'></i>
                <span>Staff Management</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.doctors') }}" class="sidebar-link {{ request()->routeIs('admin.doctors') ? 'active' : '' }}">
                <i class='bx bx-plus-medical'></i>
                <span>Doctors</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.midwives') }}" class="sidebar-link {{ request()->routeIs('admin.midwives') ? 'active' : '' }}">
                <i class='bx bx-female-sign'></i>
                <span>Midwives</span>
            </a>
        </li>

        <li class="menu-title">Settings</li>

        <li>
            <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <i class='bx bx-bar-chart'></i>
                <span>Reports</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.profile') }}" class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class='bx bx-user'></i>
                <span>My Profile</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.notifications') }}" class="sidebar-link {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                <i class='bx bx-bell'></i>
                <span>Notifications</span>
            </a>
        </li>

    </ul>

</div>
