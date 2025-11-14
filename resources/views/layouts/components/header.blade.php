<header class="header">
    <div class="header-left">
        <h1 id="menu-title">{{ $pageTitle ?? 'Dashboard' }}</h1>
        <p class="date" id="current-date">{{ now()->format('l, F j, Y') }}</p>
    </div>

    <div class="header-center">
        <!-- Search -->
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <i class='bx bx-search icon search-icon'></i>
        </div>
    </div>

    <div class="header-right">
        <!-- Notification -->
        <i class='bx bx-bell icon notification'></i>

        <!-- User Dropdown -->
        <div class="user-menu">
            <span class="user-name" onclick="toggleDropdown()">
                <i class='bx bx-user-circle user-icon'></i>
                @php
                    $user = Auth::user();
                    $name = 'User';
                    if ($user->role === 'patient' && $user->patient) {
                        $name = trim($user->patient->first_name . ' ' . ($user->patient->middle_name ?? '') . ' ' . $user->patient->last_name);
                    } elseif ($user->role !== 'patient') {
                        // For staff/doctor/midwife, you might want to add a name field to users table later
                        $name = $user->email;
                    }
                @endphp
                {{ $name }}
                <i class='bx bx-chevron-down'></i>
            </span>

            <ul class="dropdown" id="dropdown-menu">
                <li onclick="openLogoutModal()">
                    <i class='bx bx-log-out'></i> Logout
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- Logout Modal -->
<div class="modal" id="logout-modal">
    <div class="modal-content">
        <h3><i class='bx bx-log-out-circle'></i> Confirm Logout</h3>
        <p>Are you sure you want to logout?</p>

        <div class="modal-actions">
            <button class="cancel" onclick="closeLogoutModal()">Cancel</button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout">
                    <i class='bx bx-power-off'></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{--   JAVASCRIPT INSIDE FILE  --}}
{{-- ========================= --}}
<script>
// Toggle user dropdown
function toggleDropdown() {
    const menu = document.getElementById("dropdown-menu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

// Logout Modal
function openLogoutModal() {
    document.getElementById("logout-modal").style.display = "flex";
}

function closeLogoutModal() {
    document.getElementById("logout-modal").style.display = "none";
}

// Ensure logout modal is hidden on load
document.addEventListener("DOMContentLoaded", () => {
    closeLogoutModal();
});

// Dynamic Title (based on sidebar click)
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".sidebar-link").forEach(link => {
        link.addEventListener("click", function () {
            const title = this.querySelector("span").textContent.trim();
            document.getElementById("menu-title").textContent = title;

            // Active state
            document.querySelectorAll(".sidebar-link").forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
</script>
