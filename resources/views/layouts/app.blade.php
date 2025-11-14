<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MEDICARE')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Boxicons --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    {{-- Global Styles --}}
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    @stack('styles')
</head>

<body>

    @auth
        @php
            $user = Auth::user();
            $role = $user->role;

            // Sidebar mapping
            $sidebarMap = [
                'patient' => 'patient',
                'doctor' => 'doctor',
                'midwife' => 'midwife',
                'staff'   => 'admin'
            ];

            $sidebarFile = $sidebarMap[$role] ?? 'patient';

            // Patient profile validation
            $profileComplete = false;
            if ($role === 'patient' && $user->patient) {
                $profileComplete = !empty($user->patient->address);
            } else {
                $profileComplete = true;
            }
        @endphp

        {{-- Include SIDEBAR --}}
        @includeIf("layouts.components.sidebar.$sidebarFile")

        {{-- Include HEADER --}}
        @include("layouts.components.header")

        {{-- Pass JS profile status --}}
        <script>
            window.profileComplete = @json($profileComplete);
        </script>
    @endauth



    {{-- Main Page Content --}}
    <div class="main-content">

        {{-- Flash Messages --}}
        @if(session('message'))
            <div class="alert success">{{ session('message') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>




    {{-- Profile Modal for Patients --}}
    @auth
        @if($role === 'patient')
        <div id="profileModal" class="modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Profile Incomplete</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Please complete your profile to access this feature.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('profile.complete') }}" class="btn-modal-primary">
                        Complete Profile
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endauth


    {{-- Scripts --}}
    @stack('scripts')

    {{-- Patient Profile Validation Script --}}
    @auth
        @if($role === 'patient')
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const modal = document.getElementById("profileModal");
                    const links = document.querySelectorAll(".sidebar-link[data-requires-profile='true']");

                    links.forEach(link => {
                        link.addEventListener("click", function(e) {
                            if (!window.profileComplete) {
                                e.preventDefault();
                                modal.style.display = "flex";
                            }
                        });
                    });

                    document.querySelector(".modal-close")?.addEventListener("click", () => {
                        modal.style.display = "none";
                    });

                    modal.addEventListener("click", (e) => {
                        if (e.target === modal) modal.style.display = "none";
                    });
                });
            </script>
        @endif
    @endauth

</body>
</html>
