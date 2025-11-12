<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare | Barangay Health Clinic</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ time() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ asset('js/nav.js') }}"></script>
</head>

<body>

    @include('layouts.nav')

    <!-- HERO SECTION -->
    <section id="hero" class="hero-section">
        <div class="hero-text">
            <h1>Efficient Care, Anytime.</h1>
            <p>Your trusted barangay health clinic. Book appointments online with ease.</p>

            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-primary">Book Appointment</a>
                <a href="#services" class="btn-secondary">See Services</a>
            </div>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/hero.jpg') }}" alt="Clinic Illustration">
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="services" class="services-section">
        <h2>Our Services</h2>
        <p class="section-subtitle">We offer quality healthcare support for your needs.</p>

        <div class="services-grid">

            <div class="service-card">
                <i class='bx bx-plus-medical'></i>
                <h3>General Check-up</h3>
                <p>Consult with health workers regarding common symptoms and basic examinations.</p>
            </div>

            <div class="service-card">
                <i class='bx bx-female'></i>
                <h3>Maternal Check-up</h3>
                <p>Prenatal and postnatal monitoring provided by midwives.</p>
            </div>

            <div class="service-card">
                <i class='bx bxs-injection'></i>
                <h3>Vaccination</h3>
                <p>Routine immunization and required vaccination schedules for all ages.</p>
            </div>

            <div class="service-card">
                <i class='bx bx-heart'></i>
                <h3>Doctor Consultation</h3>
                <p>Available during scheduled doctor hours for medical assessment.</p>
            </div>

            <div class="service-card">
                <i class='bx bx-user-voice'></i>
                <h3>Midwife Consultation</h3>
                <p>Midwife consultation for maternal or women's health concerns.</p>
            </div>

        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="about-section">
        <div>
             <h2>About the Barangay Health Clinic</h2>
            <p>
                MediCare aims to improve accessibility and reduce waiting time by allowing residents to book
                appointments online. Our team is committed to providing reliable and community-centered healthcare.
            </p>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="contact-section">
        <div>
            <h2>Contact Us</h2>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Barangay Health Center</h3>
                    <p><i class='bx bxs-phone-call'></i> Contact Number: 0912-345-6789</p>
                    <p><i class='bx bxs-envelope'></i> Email: barangay@medicare.com</p>
                    <p><i class='bx bxs-map'></i> Purok Burbos, Poblacion Ward III, Minglanilla</p>
                    <p><i class='bx bxs-time'></i> Open: Monday - Sunday</p>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')



</body>
</html>
